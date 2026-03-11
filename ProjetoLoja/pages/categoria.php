<?php
require_once dirname(__DIR__) . '/includes/config.php';

// Inclui o array de iPhones
require_once dirname(__DIR__) . '/includes/data.php';

// Obtém o tipo de categoria da URL (lacrados ou seminovos)
$tipo = isset($_GET['tipo']) ? strtolower($_GET['tipo']) : '';

// Valida ou define título
if ($tipo === 'lacrados') {
    $titulo_pagina = 'Lançamentos Lacrados';
    $badge_texto = 'Novo';
    $badge_estilo = '';
    
    $produtos = array_filter($iphones, function($iphone) {
        return strpos(strtolower($iphone['condicao']), 'novo') !== false;
    });
} elseif ($tipo === 'seminovos') {
    $titulo_pagina = 'Seminovos Premium A+';
    $badge_texto = 'Usado Certificado';
    $badge_estilo = 'background: rgba(255,149,0,0.15); color: #ff9f0a;';
    
    $produtos = array_filter($iphones, function($iphone) {
        return strpos(strtolower($iphone['condicao']), 'seminovo') !== false;
    });
} else {
    // Redireciona para o início se o tipo for inválido
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

// Inclui o topo da página
require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="container products-wrapper" style="padding-top: 40px;">

    <!-- Breadcrumb de Navegação -->
    <div class="breadcrumb" style="padding-top: 0; padding-bottom: 24px;">
        <a href="<?= BASE_URL ?>/index.php">Início</a>
        <span class="breadcrumb-separator">&rsaquo;</span>
        <span style="color: var(--text-main);"><?= htmlspecialchars($titulo_pagina) ?></span>
    </div>

    <h1 class="section-title" style="font-size: 2.2rem; border-bottom: none; margin-bottom: 10px;">
        <span><?= htmlspecialchars($titulo_pagina) ?></span>
    </h1>
    <p style="color: var(--text-secondary); margin-bottom: 40px;">Exibindo todos os modelos disponíveis no estoque.</p>

    <!-- Grid de Produtos completo -->
    <div class="products-grid" style="margin-bottom: 60px;">
        <?php foreach ($produtos as $iphone): ?>
            <a href="<?= BASE_URL ?>/pages/detalhes.php?id=<?= $iphone["id'] ?>" class="product-card">
                <span class="badge-condition" style="<?= $badge_estilo ?>"><?= $badge_texto ?></span>
                
                <div class="product-image-wrapper">
                    <img src="<?= htmlspecialchars($iphone['imagem_url']) ?>" alt="iPhone <?= htmlspecialchars($iphone['nome']) ?>" class="product-image">
                </div>
                
                <h3 class="product-title">iPhone <?= htmlspecialchars($iphone['nome']) ?></h3>
                <div class="product-specs">
                    <?= $tipo === 'lacrados' ? 'Múltiplas Cores' : 'Garantia de 3 meses' ?> | <?= htmlspecialchars($iphone['capacidade']) ?>
                </div>
                
                <p class="product-price">R$ <?= number_format($iphone['preco'], 2, ',', '.') ?></p>
                <p class="product-installments">à vista no Pix ou até 12x</p>
                
                <span class="btn btn-outline btn-block"><?= $tipo === 'lacrados' ? 'Comprar' : 'Ver Detalhes' ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Feito para voltar rapidamente -->
    <div style="text-align: center; padding-bottom: 40px;">
        <a href="<?= BASE_URL ?>/index.php" class="btn btn-secondary" style="border: none;">&lsaquo; Voltar ao Início</a>
    </div>

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
