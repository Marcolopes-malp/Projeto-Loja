<?php
require_once dirname(__DIR__) . '/includes/config.php';

session_start(); // Inicia a sessão para controle de login

require_once dirname(__DIR__) . '/includes/conexao.php';

/**
 * Registra um novo usuário no sistema (MySQL).
 */
function register_user($nome, $email, $senha) {
    global $pdo;

    try {
        // Verifica se o email já existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['sucesso' => false, 'mensagem' => 'Este e-mail já está cadastrado.'];
        }

        // Cria o novo usuário
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        
        if ($stmt->execute([trim($nome), trim($email), $hash])) {
            return [
                'sucesso' => true,
                'usuario' => [
                    'id' => $pdo->lastInsertId(),
                    'nome' => trim($nome),
                    'email' => trim($email)
                ]
            ];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao inserir no banco de dados.'];
        }
    } catch (PDOException $e) {
        return ['sucesso' => false, 'mensagem' => 'Erro de banco de dados: ' . $e->getMessage()];
    }
}

/**
 * Faz o login do usuário verificando a senha no banco de dados.
 */
function login_user($email, $senha) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
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

        return ['sucesso' => false, 'mensagem' => 'E-mail não encontrado.'];
    } catch (PDOException $e) {
        return ['sucesso' => false, 'mensagem' => 'Erro de banco de dados: ' . $e->getMessage()];
    }
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
    session_write_close();
    header("Location: $url");
    exit;
}
?>
