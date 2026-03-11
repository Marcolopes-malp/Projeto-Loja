<?php
require_once dirname(__DIR__) . '/includes/auth.php';

// Se já estiver logado, manda pro início
if (is_logged_in()) {
    redirect('/ProjetoLoja/ProjetoLoja/index.php');
}

$erro = '';

// Processa o form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha e-mail e senha.';
    } else {
        $login = login_user($email, $senha);
        if ($login['sucesso']) {
            redirect('/ProjetoLoja/ProjetoLoja/index.php');
        } else {
            $erro = $login['mensagem'];
        }
    }
}

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="container" style="min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
    
    <div style="background: var(--card-bg); border-radius: 24px; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: center;">
        
        <div style="margin-bottom: 24px; color: var(--text-main);">
            <!-- Ícone maçã Apple simples -->
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="opacity: 0.9"><path d="M16.36 14c.08-.02.44-2.12 1.63-3.4-.8-1.55-2.61-1.74-3.13-1.78-1.63-.17-3.21 1.05-4.04 1.05-.8 0-2.12-.99-3.41-.95C5.64 8.94 4 10.15 3.08 11.9c-1.85 3.51-.48 8.65 1.34 11.45.89 1.37 1.94 2.92 3.32 2.87 1.32-.06 1.83-.9 3.35-.9 1.51 0 1.99.9 3.37.88 1.41-.02 2.32-1.42 3.2-2.78 1.03-1.57 1.45-3.08 1.47-3.16-.04-.02-2.82-1.12-2.77-4.26zM12.92 6.53c.72-.94 1.2-2.26 1.07-3.53-1.07.05-2.45.76-3.2 1.68-.68.81-1.25 2.16-1.1 3.4 1.21.1 2.45-.63 3.23-1.55z"/></svg>
        </div>
        
        <h1 style="font-size: 2rem; margin-bottom: 8px;">Entrar</h1>
        <p style="color: var(--text-secondary); margin-bottom: 30px;">Acesse sua conta para ver seus pedidos.</p>
        
        <?php if ($erro): ?>
            <div style="background: #FFF1F0; color: #E53935; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: left;">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" style="text-align: left;">
            <div style="margin-bottom: 16px;">
                <label for="email" style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 8px;">E-mail</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                       style="width: 100%; padding: 14px; border: 1px solid var(--border-color); border-radius: 12px; font-size: 1rem; font-family: inherit; transition: border-color 0.2s;"
                       placeholder="seu@email.com">
            </div>

            <div style="margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px;">
                    <label for="senha" style="font-size: 0.9rem; font-weight: 500;">Senha</label>
                    <a href="#" style="font-size: 0.85rem; color: var(--accent-color); text-decoration: none;">Esqueceu a senha?</a>
                </div>
                <input type="password" id="senha" name="senha" required 
                       style="width: 100%; padding: 14px; border: 1px solid var(--border-color); border-radius: 12px; font-size: 1rem; font-family: inherit; transition: border-color 0.2s;"
                       placeholder="Sua senha">
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 16px; font-size: 1.05rem;">Entrar</button>
        </form>
        
        <p style="margin-top: 24px; font-size: 0.95rem; color: var(--text-secondary);">
            Novo por aqui? <a href="/ProjetoLoja/ProjetoLoja/pages/cadastro.php" style="color: var(--accent-color); font-weight: 500; text-decoration: none;">Crie sua conta</a>
        </p>
    </div>

</div>

<script>
// Um pequeno UX para destacar o input (foco)
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('focus', () => {
        input.style.borderColor = 'var(--accent-color)';
        input.style.outline = 'none';
        input.style.boxShadow = '0 0 0 4px rgba(0, 113, 227, 0.1)';
    });
    input.addEventListener('blur', () => {
        input.style.borderColor = 'var(--border-color)';
        input.style.boxShadow = 'none';
    });
});
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
