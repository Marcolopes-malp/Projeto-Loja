<?php
require_once dirname(__DIR__) . '/includes/config.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['user']);
$nome_usuario = $is_logged_in ? explode(' ', $_SESSION['user']['nome'])[0] : '';

// Calculate total cart items
$cart_count = 0;
if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $cart_count += (int)$item['quantidade'];
    }
}

// Fetch user favorites if logged in
$user_favorites = [];
if ($is_logged_in) {
    require_once dirname(__DIR__) . '/includes/conexao.php';
    try {
        $stmt = $pdo->prepare("SELECT id_produto FROM favoritos WHERE id_usuario = ?");
        $stmt->execute([$_SESSION['user']['id']]);
        $user_favorites = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFIphones - O seu Apple Premium Reseller</title>
    
    <script>
        const BASE_URL = "<?= BASE_URL ?>";
        const IS_LOGGED_IN = <?= $is_logged_in ? 'true' : 'false' ?>;
        <?php if ($is_logged_in): ?>
        // Sync DB favorites to localStorage so frontend works seamlessly
        localStorage.setItem('rf_wishlist', JSON.stringify(<?= json_encode(array_map('intval', $user_favorites)) ?>));
        <?php endif; ?>
    </script>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Principal -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/estilo.css">
    
    <style>
        .cart-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background-color: var(--accent-color);
            color: white;
            font-size: 0.70rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 99px;
            line-height: 1;
            border: 2px solid white;
        }
    </style>
</head>
<body>

<!-- Faixa Superior de Avisos -->
<div class="topbar">
    FRETE GRÁTIS PARA TODO O BRASIL EM COMPRAS ACIMA DE R$ 2.999
</div>

<header class="navbar">
    <!-- Navbar Superior com Busca e Ícones -->
    <div class="container navbar-main">
        <a href="<?= BASE_URL ?>/index.php" class="navbar-brand">
            <!-- Ícone maçã Apple simples -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M16.36 14c.08-.02.44-2.12 1.63-3.4-.8-1.55-2.61-1.74-3.13-1.78-1.63-.17-3.21 1.05-4.04 1.05-.8 0-2.12-.99-3.41-.95C5.64 8.94 4 10.15 3.08 11.9c-1.85 3.51-.48 8.65 1.34 11.45.89 1.37 1.94 2.92 3.32 2.87 1.32-.06 1.83-.9 3.35-.9 1.51 0 1.99.9 3.37.88 1.41-.02 2.32-1.42 3.2-2.78 1.03-1.57 1.45-3.08 1.47-3.16-.04-.02-2.82-1.12-2.77-4.26zM12.92 6.53c.72-.94 1.2-2.26 1.07-3.53-1.07.05-2.45.76-3.2 1.68-.68.81-1.25 2.16-1.1 3.4 1.21.1 2.45-.63 3.23-1.55z"/></svg>
            RFIphones
        </a>
        
        <form action="<?= BASE_URL ?>/pages/busca.php" method="GET" class="navbar-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="q" placeholder="Buscar por iPhone, iPad, Mac...">
        </form>
        
        <div class="navbar-icons">
            <?php if ($is_logged_in): ?>
                <div class="dropdown" style="position: relative; display: inline-block;">
                    <a href="#" style="display: flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span class="d-none-mobile" style="color: var(--text-main); font-weight: 500;">Olá, <?= htmlspecialchars($nome_usuario) ?></span>
                    </a>
                    <div style="margin-top: 4px; font-size: 0.85rem;">
                        <a href="<?= BASE_URL ?>/pages/logout.php" style="color: var(--text-secondary); text-decoration: none;">Sair da conta</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/pages/login.php" style="display: flex; align-items: center; gap: 6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span class="icon-text">Login</span>
                </a>
            <?php endif; ?>
            
            <a href="javascript:void(0)" onclick="toggleTheme()" style="display: flex; align-items: center; gap: 6px;" title="Alternar Tema">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                <span class="icon-text d-none-mobile">Tema</span>
            </a>

            <a href="<?= BASE_URL ?>/pages/favoritos.php" style="display: flex; align-items: center; gap: 6px; position: relative;">
                <div style="position: relative;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    <span class="cart-badge" id="wishlist-badge" style="display:none; background-color: #ff2d55;">0</span>
                </div>
                <span class="icon-text d-none-mobile">Favoritos</span>
            </a>
            
            <a href="<?= BASE_URL ?>/pages/carrinho.php" style="display: flex; align-items: center; gap: 6px; position: relative;">
                <div style="position: relative;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-badge"><?= $cart_count ?></span>
                    <?php endif; ?>
                </div>
                <span class="icon-text d-none-mobile">Carrinho</span>
            </a>
        </div>
    </div>
    
    <!-- Navbar Inferior com Categorias -->
    <div class="navbar-bottom">
        <div class="container navbar-links">
            <a href="<?= BASE_URL ?>/index.php">Início</a>
            <a href="<?= BASE_URL ?>/pages/categoria.php?tipo=lacrados">Lacrados</a>
            <a href="<?= BASE_URL ?>/pages/categoria.php?tipo=seminovos">Seminovos</a>
            <!--<a href="#">Mac</a>
            <a href="#">iPad</a>
            <a href="#">Watch</a>
            <a href="#">Acessórios</a>-->
        </div>
    </div>
</header>
