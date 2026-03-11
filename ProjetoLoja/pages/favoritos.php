<?php
require_once dirname(__DIR__) . '/includes/data.php';

// Esta página será carregada vazia do PHP e preenchida dinamicamente via JS
require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="container" style="padding-top: 40px; padding-bottom: 80px; min-height: 60vh;">
    
    <div class="breadcrumb" style="padding-top: 0; padding-bottom: 24px;">
        <a href="/ProjetoLoja/ProjetoLoja/index.php">Início</a>
        <span class="breadcrumb-separator">&rsaquo;</span>
        <span style="color: var(--text-main);">Meus Favoritos</span>
    </div>

    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 40px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ff2d55" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
        <h1 style="font-size: 2.2rem;">Meus Favoritos</h1>
    </div>

    <!-- Container onde o JS vai renderizar os produtos salvos -->
    <div id="wishlist-grid" class="products-grid">
        <!-- Renderizado dinamicamente -->
    </div>

    <!-- Estado Vazio -->
    <div id="wishlist-empty" style="display: none; background: var(--card-bg); border-radius: 24px; padding: 60px 20px; text-align: center; box-shadow: var(--shadow-card);">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--border-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 20px;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
        <h2 style="font-size: 1.5rem; margin-bottom: 12px;">Sua lista de desejos está vazia</h2>
        <p style="color: var(--text-secondary); margin-bottom: 30px;">Explore a loja e clique no coração dos produtos que você mais gostou.</p>
        <a href="/ProjetoLoja/ProjetoLoja/index.php" class="btn btn-primary" style="padding: 14px 30px;">Explorar Modelos</a>
    </div>

</div>

<!-- Para conseguir renderizar, passamos o array do PHP de forma simplificada para o JS -->
<script>
// Dados de catálogo base
const catalogoIphones = <?= json_encode($iphones) ?>;

document.addEventListener('DOMContentLoaded', () => {
    renderWishlist();
});

function renderWishlist() {
    const wishlistIds = JSON.parse(localStorage.getItem('rf_wishlist') || '[]');
    const grid = document.getElementById('wishlist-grid');
    const emptyState = document.getElementById('wishlist-empty');
    
    // Limpa o grid
    grid.innerHTML = '';
    
    if (wishlistIds.length === 0) {
        grid.style.display = 'none';
        emptyState.style.display = 'block';
        return;
    }
    
    grid.style.display = 'grid';
    emptyState.style.display = 'none';
    
    // Filtra e renderiza
    wishlistIds.forEach(id => {
        const produto = catalogoIphones[id];
        if (produto) {
            const card = document.createElement('a');
            card.href = `/ProjetoLoja/ProjetoLoja/pages/detalhes.php?id=${produto.id}`;
            card.className = 'product-card';
            card.style.position = 'relative';
            
            // Botão de remover que não clica o link inteiro
            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '&times;';
            removeBtn.style = 'position: absolute; top: 12px; right: 12px; width: 30px; height: 30px; border-radius: 50%; border: none; background: rgba(0,0,0,0.1); color: var(--text-main); font-size: 1.2rem; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; transition: 0.2s; backdrop-filter: blur(4px);';
            removeBtn.onmouseover = () => removeBtn.style.background = 'rgba(255,59,48,0.2)';
            removeBtn.onmouseout = () => removeBtn.style.background = 'rgba(0,0,0,0.1)';
            removeBtn.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                toggleWishlist(produto.id, `iPhone ${produto.nome}`);
                renderWishlist(); // re-renderiza a página
            };
            
            card.innerHTML = `
                <div class="product-image-wrapper">
                    <img src="${produto.imagem_url}" alt="iPhone ${produto.nome}" class="product-image">
                </div>
                <h3 class="product-title">iPhone ${produto.nome}</h3>
                <div class="product-specs">${produto.capacidade} &bull; ${produto.condicao}</div>
                <p class="product-price">R$ ${Number(produto.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits:2})}</p>
                <span class="btn btn-outline btn-block" style="margin-top: 16px;">Ver Aparelho</span>
            `;
            
            card.appendChild(removeBtn);
            grid.appendChild(card);
        }
    });
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
