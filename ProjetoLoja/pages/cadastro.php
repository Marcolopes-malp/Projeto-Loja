<?php
require_once dirname(__DIR__) . '/includes/config.php';

require_once dirname(__DIR__) . '/includes/auth.php';

// Se já estiver logado, manda pro início
if (is_logged_in()) {
    redirect(BASE_URL . "/index.php");
}

$erro = '';
$sucesso = '';

// Processa o form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $senha_confirma = $_POST['senha_confirma'] ?? '';

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } elseif ($senha !== $senha_confirma) {
        $erro = 'As senhas não coincidem.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        $registro = register_user($nome, $email, $senha);
        if ($registro['sucesso']) {
            // Loga automaticamente e vai pro inicio
            login_user($email, $senha);
            redirect(BASE_URL . "/index.php");
        } else {
            $erro = $registro['mensagem'];
        }
    }
}

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="container" style="min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
    
    <div style="background: var(--card-bg); border-radius: 24px; padding: 40px; width: 100%; max-width: 480px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: center;">
        
        <h1 style="font-size: 2rem; margin-bottom: 8px;">Criar Conta</h1>
        <p style="color: var(--text-secondary); margin-bottom: 30px;">Junte-se à RFIphones para ofertas exclusivas.</p>
        
        <?php if ($erro): ?>
            <div style="background: #FFF1F0; color: #E53935; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: left;">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/pages/cadastro.php" style="text-align: left;">
            <div style="margin-bottom: 16px;">
                <label for="nome" style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 8px;">Nome Completo</label>
                <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" 
                       style="width: 100%; padding: 14px; border: 1px solid var(--border-color); border-radius: 12px; font-size: 1rem; font-family: inherit; transition: border-color 0.2s;"
                       placeholder="Seu nome">
            </div>
            
            <div style="margin-bottom: 16px;">
                <label for="email" style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 8px;">E-mail</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                       style="width: 100%; padding: 14px; border: 1px solid var(--border-color); border-radius: 12px; font-size: 1rem; font-family: inherit; transition: border-color 0.2s;"
                       placeholder="seu@email.com">
            </div>

            <div style="margin-bottom: 16px;">
                <label for="senha" style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 8px;">Senha</label>
                <input type="password" id="senha" name="senha" required 
                       style="width: 100%; padding: 14px; border: 1px solid var(--border-color); border-radius: 12px; font-size: 1rem; font-family: inherit; transition: border-color 0.2s;"
                       placeholder="Mínimo de 6 caracteres">
            </div>
            
            <div style="margin-bottom: 24px;">
                <label for="senha_confirma" style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 8px;">Confirmar Senha</label>
                <input type="password" id="senha_confirma" name="senha_confirma" required 
                       style="width: 100%; padding: 14px; border: 1px solid var(--border-color); border-radius: 12px; font-size: 1rem; font-family: inherit; transition: border-color 0.2s;"
                       placeholder="Repita sua senha">
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 16px; font-size: 1.05rem;">Cadastrar</button>
        </form>
        
        <p style="margin-top: 24px; font-size: 0.95rem; color: var(--text-secondary);">
            Já tem uma conta? <a href="<?= BASE_URL ?>/pages/login.php" style="color: var(--accent-color); font-weight: 500; text-decoration: none;">Faça login</a>
        </p>
    </div>

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
