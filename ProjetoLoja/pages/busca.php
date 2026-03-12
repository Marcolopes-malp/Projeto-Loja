<?php
require_once dirname(__DIR__) . '/includes/config.php';

require_once dirname(__DIR__) . '/includes/data.php';

$termo_busca = isset($_GET['q']) ? trim($_GET['q']) : '';

// Filtrar o array manual de iphones
$resultados = [];
if (!empty($termo_busca)) {
    $termos = explode(' ', strtolower($termo_busca));
    
    foreach ($iphones as $iphone) {
        $texto_busca = strtolower($iphone['nome'] . ' ' . $iphone['condicao'] . ' ' . $iphone['capacidade'] . ' ' . $iphone['descricao']);
        
        $match = true;
        foreach ($termos as $termo) {
            if (strpos($texto_busca, $termo) === false) {
                $match = false;
                break;
            }
        }
        
        if ($match) {
            $resultados[] = $iphone;
        }
    }
}

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="container products-wrapper" style="padding-top: 40px; min-height: 60vh;">

    <!-- Breadcrumb -->
    <div class="breadcrumb" style="padding-top: 0; padding-bottom: 24px;">
        <a href="<?= BASE_URL ?>/index.php">Início</a>
        <span class="breadcrumb-separator">&rsaquo;</span>
        <span style="color: var(--text-main);">Resultados da Busca</span>
    </div>

    <h1 class="section-title" style="font-size: 2.2rem; border-bottom: none; margin-bottom: 10px;">
        <span>Busca por: "<?= htmlspecialchars($termo_busca) ?>"</span>
    </h1>
    <p style="color: var(--text-secondary); margin-bottom: 40px;">
        Encontramos <?= count($resultados) ?> resultado(s) para a sua pesquisa.
    </p>

    <!-- Grid de Produtos completo -->
    <?php if (count($resultados) > 0): ?>
    <div class="products-grid" style="margin-bottom: 60px;">
        <?php foreach ($resultados as $iphone): ?>
            <?php 
                $badge_texto = strpos(strtolower($iphone['condicao']), 'novo') !== false ? 'Novo' : 'Usado Certificado';
                $badge_estilo = $badge_texto === 'Novo' ? '' : 'background: rgba(255,149,0,0.15); color: #ff9f0a;';
            ?>
            <a href="<?= BASE_URL ?>/pages/detalhes.php?id=<?= $iphone['id'] ?>" class="product-card">
                <span class="badge-condition" style="<?= $badge_estilo ?>"><?= $badge_texto ?></span>
                
                <div class="product-image-wrapper">
                    <img src="<?= htmlspecialchars($iphone['imagem_url']) ?>" alt="iPhone <?= htmlspecialchars($iphone['nome']) ?>" class="product-image">
                </div>
                
                <h3 class="product-title">iPhone <?= htmlspecialchars($iphone['nome']) ?></h3>
                <div class="product-specs">
                    <?= htmlspecialchars($iphone['condicao']) ?> | <?= htmlspecialchars($iphone['capacidade']) ?>
                </div>
                
                <p class="product-price">R$ <?= number_format($iphone['preco'], 2, ',', '.') ?></p>
                <p class="product-installments">à vista no Pix ou até 12x</p>
                
                <span class="btn btn-outline btn-block">Ver Detalhes</span>
            </a>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <div style="background: var(--card-bg); border-radius: 24px; padding: 60px 20px; text-align: center; box-shadow: var(--shadow-card); margin-bottom: 60px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--border-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 20px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <h2 style="font-size: 1.5rem; margin-bottom: 12px;">Nenhum produto encontrado</h2>
            <p style="color: var(--text-secondary); margin-bottom: 30px;">Tente pesquisar por termos como "Pro Max", "128GB" ou "14".</p>
            <a href="<?= BASE_URL ?>/index.php" class="btn btn-primary" style="padding: 14px 30px;">Voltar ao Início</a>
        </div>
    <?php endif; ?>

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
