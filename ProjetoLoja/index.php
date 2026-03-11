
<?php
// Inclui o arquivo contendo o array $iphones
require_once __DIR__ . '/includes/data.php';

// Filtra os produtos por categoria
$lacrados = array_filter($iphones, function($iphone) {
    return strpos(strtolower($iphone['condicao']), 'novo') !== false;
});

$seminovos = array_filter($iphones, function($iphone) {
    return strpos(strtolower($iphone['condicao']), 'seminovo') !== false;
});

// Inclui o topo da página (header)
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Slider Animado -->
<section class="hero-slider">
    <div class="slide active-slide">
        <div class="slide-content">
            <h1>iPhone 17 Pro.</h1>
            <p>Titânio. Mais forte. Mais leve. Mais Pro.</p>
            <a href="./pages/categoria.php?tipo=lacrados" class="btn btn-outline" style="margin-top: 24px;">Comprar Agora</a>
        </div>
    </div>
    <div class="slide" style="background: linear-gradient(135deg, #1d1d1f 0%, #000 100%);">
        <div class="slide-content">
            <h1 style="color: #f5f5f7;">Seminovos Premium A+</h1>
            <p style="color: #a1a1a6;">Certificação direta e desconto de até 40%. Qualidade impecável.</p>
            <a href="./pages/categoria.php?tipo=seminovos" class="btn btn-outline" style="margin-top: 24px; border-color: #f5f5f7; color: #f5f5f7;">Ver Modelos</a>
        </div>
    </div>
    <div class="slide-controls">
        <span class="slide-dot active-dot" onclick="goToHeroSlide(0)"></span>
        <span class="slide-dot" onclick="goToHeroSlide(1)"></span>
    </div>
</section>

<style>
.hero-slider {
    position: relative;
    height: 400px;
    margin-bottom: 50px;
    overflow: hidden;
    background: var(--bg-body);
}

.slide {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background: linear-gradient(135deg, #f5f5f7 0%, #e5e5ea 100%);
    border-bottom: 1px solid var(--border-light);
}

[data-theme="dark"] .slide {
    background: linear-gradient(135deg, #111111 0%, #1c1c1e 100%);
}

.slide.active-slide {
    opacity: 1;
    z-index: 10;
}

.slide-content h1 {
    font-size: 3.5rem;
    font-weight: 700;
    letter-spacing: -1px;
    margin-bottom: 16px;
    background: linear-gradient(to right, var(--text-main), var(--text-secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.slide-content p {
    font-size: 1.25rem;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
}

.slide-controls {
    position: absolute;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 20;
    display: flex;
    gap: 12px;
}

.slide-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: rgba(134, 134, 139, 0.4);
    cursor: pointer;
    transition: all 0.3s ease;
}

.slide-dot.active-dot {
    background: var(--text-main);
    transform: scale(1.3);
}
</style>

<script>
let currentHeroSlide = 0;
const heroSlides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.slide-dot');

function goToHeroSlide(index) {
    heroSlides[currentHeroSlide].classList.remove('active-slide');
    dots[currentHeroSlide].classList.remove('active-dot');
    
    currentHeroSlide = index;
    
    heroSlides[currentHeroSlide].classList.add('active-slide');
    dots[currentHeroSlide].classList.add('active-dot');
}

setInterval(() => {
    let next = currentHeroSlide + 1;
    if (next >= heroSlides.length) next = 0;
    goToHeroSlide(next);
}, 5000);
</script>

<div class="container products-wrapper">

<!-- Seção: Lacrados -->
<h2 class="section-title" id="lacrados">
    <span>Lançamentos Lacrados</span>
    <a href="./pages/categoria.php?tipo=lacrados" class="section-link">Ver todos &rsaquo;</a>
</h2>
<div class="products-grid" style="margin-bottom: 30px;">
    <?php foreach (array_slice($lacrados, 0, 4) as $iphone): ?>
        <a href="./pages/detalhes.php?id=<?= $iphone['id'] ?>" class="product-card">
            <span class="badge-condition">Novo</span>
            
            <div class="product-image-wrapper">
                <img src="<?= htmlspecialchars($iphone['imagem_url']) ?>" alt="iPhone <?= htmlspecialchars($iphone['nome']) ?>" class="product-image">
            </div>
            
            <h3 class="product-title">iPhone <?= htmlspecialchars($iphone['nome']) ?></h3>
            <div class="product-specs">
                Múltiplas Cores | <?= htmlspecialchars($iphone['capacidade']) ?>
            </div>
            
            <p class="product-price">R$ <?= number_format($iphone['preco'], 2, ',', '.') ?></p>
            <p class="product-installments">à vista no Pix ou até 12x</p>
            
            <span class="btn btn-outline btn-block">Comprar</span>
        </a>
    <?php endforeach; ?>
</div>

<?php if (count($lacrados) > 4): ?>
<div style="text-align: center; margin-bottom: 60px;">
    <a href="./pages/categoria.php?tipo=lacrados" class="btn btn-outline" style="padding: 10px 40px; border-radius: 980px; text-decoration: none;">Ver mais modelos Lacrados</a>
</div>
<?php endif; ?>

<!-- Seção: Seminovos Premium -->
<h2 class="section-title" id="seminovos">
    <span>Seminovos Premium A+</span>
    <a href="./pages/categoria.php?tipo=seminovos" class="section-link">Ver todos &rsaquo;</a>
</h2>
<div class="products-grid" style="margin-bottom: 30px;">
    <?php foreach (array_slice($seminovos, 0, 8) as $iphone): ?>
        <a href="./pages/detalhes.php?id=<?= $iphone['id'] ?>" class="product-card">
            <span class="badge-condition" style="background: rgba(255,149,0,0.15); color: #ff9f0a;">Usado Certificado</span>
            
            <div class="product-image-wrapper">
                <img src="<?= htmlspecialchars($iphone['imagem_url']) ?>" alt="iPhone <?= htmlspecialchars($iphone['nome']) ?>" class="product-image">
            </div>
            
            <h3 class="product-title">iPhone <?= htmlspecialchars($iphone['nome']) ?></h3>
            <div class="product-specs">
                Garantia de 3 meses | <?= htmlspecialchars($iphone['capacidade']) ?>
            </div>
            
            <p class="product-price">R$ <?= number_format($iphone['preco'], 2, ',', '.') ?></p>
            <p class="product-installments">à vista no Pix ou até 12x</p>
            
            <span class="btn btn-outline btn-block">Ver Detalhes</span>
        </a>
    <?php endforeach; ?>
</div>

<?php if (count($seminovos) > 8): ?>
<div style="text-align: center; margin-bottom: 60px;">
    <a href="./pages/categoria.php?tipo=seminovos" class="btn btn-outline" style="padding: 10px 40px; border-radius: 980px; text-decoration: none;">Ver mais modelos Seminovos</a>
</div>
<?php endif; ?>

</div> <!-- Fecha container -->

<!-- Seção: Vistos Recentemente -->
<div class="container" id="recent-container" style="display: none; margin-bottom: 60px;">
    <h2 class="section-title">
        <span>Vistos Recentemente</span>
    </h2>
    <div class="products-grid" id="recent-grid">
        <!-- Renderizado dinamicamente pelo JS principal -->
    </div>
</div>

<!-- Seção: Avaliações dos Clientes -->
<section style="background: var(--bg-card); padding: 80px 0; border-top: 1px solid var(--border-light); border-bottom: 1px solid var(--border-light); margin-bottom: 60px;">
    <div class="container">
        <h2 class="section-title" style="border-bottom: none; text-align: center; justify-content: center; margin-bottom: 50px;">
            <span>O que nossos clientes dizem</span>
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <?php foreach ($avaliacoes as $av): ?>
                <div style="background: var(--bg-body); padding: 30px; border-radius: var(--radius-lg); border: 1px solid var(--border-light); text-align: center;">
                    <div style="color: #FFD700; font-size: 1.5rem; margin-bottom: 16px;">
                        <?= str_repeat('★', $av['estrelas']) ?>
                    </div>
                    <p style="font-size: 1.1rem; font-style: italic; margin-bottom: 20px;">"<?= htmlspecialchars($av['texto']) ?>"</p>
                    <h4 style="font-weight: 600;">- <?= htmlspecialchars($av['nome']) ?></h4>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Script para carregar recentes na home -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const recentIds = JSON.parse(localStorage.getItem('rf_recent') || '[]');
    const container = document.getElementById('recent-container');
    const grid = document.getElementById('recent-grid');
    
    if (recentIds.length > 0) {
        // Envia os IDs reais para o backend via fetch ou renderiza com os dados locais
        // Como temos acesso ao objeto PHP `$iphones` via json_encode aqui fica fácil:
        const catIphones = <?= json_encode($iphones) ?>;
        
        let found = false;
        recentIds.slice(0, 4).forEach(id => {
            const prod = catIphones[id];
            if (prod) {
                found = true;
                grid.innerHTML += `
                    <a href="./pages/detalhes.php?id=${prod.id}" class="product-card" style="transform: scale(0.95);">
                        <div class="product-image-wrapper" style="height: 150px;">
                            <img src="${prod.imagem_url}" class="product-image">
                        </div>
                        <h3 class="product-title" style="font-size: 1rem;">iPhone ${prod.nome}</h3>
                        <p class="product-price" style="font-size: 1.1rem;">R$ ${Number(prod.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</p>
                    </a>
                `;
            }
        });
        
        if (found) {
            container.style.display = 'block';
        }
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
