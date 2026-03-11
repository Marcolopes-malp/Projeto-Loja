<?php
require_once dirname(__DIR__) . '/includes/config.php';

session_start(); // Inicia a sessão para controle de login

$users_file = dirname(__DIR__) . '/data/users.json';

// Cria o arquivo caso não exista
if (!file_exists(dirname($users_file))) {
    mkdir(dirname($users_file), 0777, true);
}
if (!file_exists($users_file)) {
    file_put_contents($users_file, '[]');
}

/**
 * Registra um novo usuário no sistema.
 */
function register_user($nome, $email, $senha) {
    global $users_file;
    $users_data = file_get_contents($users_file);
    $users = json_decode($users_data, true) ?: [];

    // Verifica se o email já existe
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return ['sucesso' => false, 'mensagem' => 'Este e-mail já está cadastrado.'];
        }
    }

    // Cria o novo usuário
    $novo_usuario = [
        'id' => uniqid(),
        'nome' => trim($nome),
        'email' => trim($email),
        'senha' => password_hash($senha, PASSWORD_DEFAULT),
        'data_cadastro' => date('Y-m-d H:i:s')
    ];

    $users[] = $novo_usuario;
    if (file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT))) {
        return ['sucesso' => true, 'usuario' => $novo_usuario];
    }

    return ['sucesso' => false, 'mensagem' => 'Erro interno ao salvar usuário.'];
}

/**
 * Faz o login do usuário verificando a senha.
 */
function login_user($email, $senha) {
    global $users_file;
    $users_data = file_get_contents($users_file);
    $users = json_decode($users_data, true) ?: [];

    foreach ($users as $user) {
        if ($user['email'] === $email) {
            if (password_verify($senha, $user['senha'])) {
                // Senha correta, define a sessão
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nome' => $user['nome'],
                    'email' => $user['email']
                ];
                return ['sucesso' => true];
            } else {
                return ['sucesso' => false, 'mensagem' => 'Senha incorreta.'];
            }
        }
    }

    return ['sucesso' => false, 'mensagem' => 'E-mail não encontrado.'];
}

/**
 * Sai do sistema destruindo a sessão.
 */
function logout_user() {
    session_destroy();
    unset($_SESSION['user']);
}

/**
 * Verifica se o usuário atual está logado.
 */
function is_logged_in() {
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

/**
 * Redireciona o usuário para uma página específica.
 */
function redirect($url) {
    header("Location: $url");
    exit;
}
?>
