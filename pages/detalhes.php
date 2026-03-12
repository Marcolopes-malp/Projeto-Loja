<?php
require_once dirname(__DIR__) . '/includes/config.php';

// Inclui o array de iPhones
require_once dirname(__DIR__) . '/includes/data.php';

// Obtém o ID da URL se ele existir, caso contrário é null
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

// Verifica se existe um iPhone com esse ID no nosso array
$iphone = null;
if ($id && isset($iphones[$id])) {
    $iphone = $iphones[$id];
}

// Lógica para montar o link do WhatsApp
if ($iphone) {
    // Numero de contato passado pelo usuário
    $numero_whatsapp = "5511993259396";
    
    // Montagem da mensagem amigável
    $mensagem = "Olá! Gostaria de comprar o *iPhone " . $iphone['nome'] . "* (" . $iphone['capacidade'] . " - " . $iphone['condicao'] . ") por R$ " . number_format($iphone['preco'], 2, ',', '.') . ". Ainda está disponível?";
    
    // Gera a URL do WhatsApp Web/App com a mensagem formatada para URL (urlencode)
    $url_whatsapp = "https://wa.me/{$numero_whatsapp}?text=" . urlencode($mensagem);
}

// Inclui o topo da página
require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="container details-page">

<?php if ($iphone): ?>
    
    <div class="breadcrumb">
        <a href="<?= BASE_URL ?>/index.php">Início</a>
        <span class="breadcrumb-separator">&rsaquo;</span>
        <a href="<?= BASE_URL ?>/index.php#<?= strpos(strtolower($iphone['condicao']), 'novo') !== false ? 'lacrados' : 'seminovos' ?>">
            <?= strpos(strtolower($iphone['condicao']), 'novo') !== false ? 'Lançamentos' : 'Seminovos' ?>
        </a>
        <span class="breadcrumb-separator">&rsaquo;</span>
        <span style="color: var(--text-main);">iPhone <?= htmlspecialchars($iphone['nome']) ?></span>
    </div>

<?php
    $imagens = [];
    if (isset($iphone['imagens']) && is_array($iphone['imagens'])) {
        $imagens = $iphone['imagens'];
    } else {
        // Fallback para 5 imagens usando a principal caso a galeria não exista no data.php ainda
        for ($i = 0; $i < 5; $i++) {
            $imagens[] = $iphone['imagem_url'];
        }
    }
    ?>
    <div class="details-wrapper">
        <div class="details-image-col">
            <div class="carousel-container">
                <button class="carousel-btn prev-btn" onclick="moveCarousel(-1)" aria-label="Imagem Anterior">&#10094;</button>
                <div class="carousel-track-wrapper">
                    <div class="carousel-track" id="carouselTrack">
                        <?php foreach ($imagens as $index => $img_url): ?>
                            <img src="<?= htmlspecialchars($img_url) ?>" alt="iPhone <?= htmlspecialchars($iphone['nome']) ?> - Vista <?= $index + 1 ?>" class="carousel-image">
                        <?php endforeach; ?>
                    </div>
                </div>
                <button class="carousel-btn next-btn" onclick="moveCarousel(1)" aria-label="Próxima Imagem">&#10095;</button>
                
                <div class="carousel-dots">
                    <?php foreach ($imagens as $index => $img_url): ?>
                        <span class="dot <?= $index === 0 ? 'active' : '' ?>" onclick="setCarousel(<?= $index ?>)"></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="details-info-col">
            <h1 class="details-title">iPhone <?= htmlspecialchars($iphone['nome']) ?></h1>
            <p class="details-condition"><?= htmlspecialchars($iphone['condicao']) ?> &bull; Desbloqueado</p>
            
            <div class="details-price-box">
                <p class="details-price">R$ <?= number_format($iphone['preco'], 2, ',', '.') ?></p>
                <p class="details-pix">À vista no Pix com desconto</p>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 8px;">Ou em até 12x no cartão de crédito com juros da operadora.</p>
            </div>
            
            <div class="details-specs">
                <div class="spec-item">
                    <span class="spec-label">Linha</span>
                    <span class="spec-value">Série <?= htmlspecialchars($iphone['linha']) ?></span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Capacidade de Armazenamento</span>
                    <span class="spec-value"><?= htmlspecialchars($iphone['capacidade']) ?></span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Garantia Incluída</span>
                    <span class="spec-value" style="color: var(--accent-color);">🛡️ <?= htmlspecialchars($iphone['garantia']) ?></span>
                </div>
            </div>

            <?php if (isset($iphone['estoque']) && $iphone['estoque'] > 0 && $iphone['estoque'] <= 3): ?>
            <div style="background: rgba(255,59,48,0.1); border: 1px solid rgba(255,59,48,0.2); color: #ff3b30; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 500; font-size: 0.95rem; display: flex; align-items: center; gap: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Corra! Restam apenas <?= $iphone['estoque'] ?> unidade(s) neste valor promocional.
            </div>
            <?php endif; ?>
            
            <div class="details-description" style="margin-top: 20px; margin-bottom: 24px; line-height: 1.6; color: var(--text-secondary);">
                <h3 style="color: var(--text-main); font-size: 1.1rem; margin-bottom: 8px;">Sobre este modelo</h3>
                <p><?= nl2br(htmlspecialchars($iphone['descricao'] ?? 'Sem descrição disponível para este modelo.')) ?></p>
            </div>
            
            <div class="details-actions" style="display: flex; flex-direction: column; gap: 12px;">
                
                <!-- Botão Adicionar ao Carrinho -->
                <form method="POST" action="<?= BASE_URL ?>/pages/carrinho_acao.php">
                    <input type="hidden" name="acao" value="add">
                    <input type="hidden" name="id" value="<?= $iphone['id'] ?>">
                    <button type="submit" class="btn btn-outline btn-block" style="display: flex; justify-content: center; align-items: center; gap: 10px; font-size: 1.1rem; padding: 18px; border-radius: 12px; font-weight: 500;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        Adicionar ao Carrinho
                    </button>
                </form>

                <!-- Botão Favoritar -->
                <button onclick="toggleWishlist(<?= $iphone['id'] ?>, '<?= htmlspecialchars($iphone['nome']) ?>', event)" class="btn btn-block wishlist-btn" style="background: var(--bg-color); color: var(--text-main); display: flex; justify-content: center; align-items: center; gap: 10px; font-size: 1.1rem; padding: 18px; border-radius: 12px; font-weight: 500; border: 1px solid var(--border-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="heart-icon"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    Adicionar aos Favoritos
                </button>


                <!-- Botão comprar agora lida com link do whats -->
                <a href="<?= htmlspecialchars($url_whatsapp) ?>" target="_blank" class="btn btn-primary btn-block" style="display: flex; justify-content: center; align-items: center; gap: 10px; font-size: 1.1rem; padding: 18px;">
                   <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                   Comprar Especialista
                </a>
            </div>
            
            <div style="margin-top: 24px; font-size: 0.85rem; color: var(--text-secondary); text-align: center;">
                <p>Ao clicar em comprar, você falará diretamente com um especialista da nossa equipe via WhatsApp.</p>
            </div>
        </div>
    </div>
<?php else: ?>
    <div style="text-align: center; padding: 100px 0;">
        <h1>Aparelho Indisponível</h1>
        <p style="color: var(--text-secondary); margin: 20px 0; font-size: 1.2rem;">Este iPhone pode ter se esgotado ou o link está incorreto.</p>
        <a href="<?= BASE_URL ?>/index.php" class="btn btn-primary">Voltar para a Página Inicial</a>
    </div>
<?php endif; ?>

</div> <!-- Fecha a div container -->

<script>
const track = document.getElementById('carouselTrack');
const dots = document.querySelectorAll('.dot');
const totalSlides = <?= count($imagens) ?>;
let currentSlide = 0;

function updateCarousel() {
    track.style.transform = `translateX(-${currentSlide * 100}%)`;
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

function moveCarousel(direction) {
    currentSlide += direction;
    if (currentSlide < 0) currentSlide = totalSlides - 1;
    if (currentSlide >= totalSlides) currentSlide = 0;
    updateCarousel();
}

function setCarousel(index) {
    currentSlide = index;
    updateCarousel();
}

// Ao carregar a página:
document.addEventListener('DOMContentLoaded', () => {
    // 1. Salva nos Vistos Recentemente
    addToRecent(<?= $iphone['id'] ?>);
    
    // 2. Atualiza o status visual do botão de coracao se já estiver favoritado
    if (isFavorited(<?= $iphone['id'] ?>)) {
        const btn = document.querySelector('.wishlist-btn');
        if (btn) btn.classList.add('active');
    }
});
</script>

<style>
/* Estilo dinâmico pro botão favoritar do Detalhes */
.wishlist-btn { transition: all 0.2s ease; }
.wishlist-btn:hover { border-color: #ff2d55 !important; color: #ff2d55 !important; }
.wishlist-btn.active { color: #ff2d55 !important; border-color: #ff2d55 !important; background: rgba(255,45,85,0.05) !important; }
.wishlist-btn.active .heart-icon { fill: #ff2d55; stroke: #ff2d55; }
</style>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
