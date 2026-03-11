/**
 * Javascript Principal da Loja
 * Funções globais: Dark Mode, Toast, Wishlist e Recentes
 */

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    updateWishlistBadge();
});

// ==========================================
// TOAST NOTIFICATIONS
// ==========================================
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <span class="toast-icon">${type === 'success' ? '✓' : 'ℹ'}</span>
        <span class="toast-message">${message}</span>
    `;
    
    toastContainer.appendChild(toast);
    
    // Animate in
    requestAnimationFrame(() => {
        toast.classList.add('show');
    });
    
    // Remove after 3s
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    document.body.appendChild(container);
    return container;
}

// ==========================================
// WISHLIST (FAVORITOS) NO LOCALSTORAGE
// ==========================================
function toggleWishlist(id, name, event) {
    if (event) {
        event.preventDefault(); // Prevent default link behavior if inside a tag
    }
    
    let wishlist = JSON.parse(localStorage.getItem('rf_wishlist') || '[]');
    const index = wishlist.indexOf(id);
    
    if (index === -1) {
        wishlist.push(id);
        showToast(`${name} adicionado aos favoritos!`, 'success');
        if(event && event.target) {
            const icon = event.target.closest('.wishlist-btn');
            if(icon) icon.classList.add('active');
        }
    } else {
        wishlist.splice(index, 1);
        showToast(`${name} removido dos favoritos!`, 'info');
        if(event && event.target) {
            const icon = event.target.closest('.wishlist-btn');
            if(icon) icon.classList.remove('active');
        }
    }
    
    localStorage.setItem('rf_wishlist', JSON.stringify(wishlist));
    updateWishlistBadge();
}

function updateWishlistBadge() {
    let wishlist = JSON.parse(localStorage.getItem('rf_wishlist') || '[]');
    const badge = document.getElementById('wishlist-badge');
    
    if (badge) {
        if (wishlist.length > 0) {
            badge.textContent = wishlist.length;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }
}

function isFavorited(id) {
    let wishlist = JSON.parse(localStorage.getItem('rf_wishlist') || '[]');
    return wishlist.includes(id);
}

// ==========================================
// VISTOS RECENTEMENTE
// ==========================================
function addToRecent(id) {
    let recent = JSON.parse(localStorage.getItem('rf_recent') || '[]');
    // Remove if already exists to put it at the top
    recent = recent.filter(item => item !== id);
    // Add to beginning
    recent.unshift(id);
    // Keep only last 10
    if (recent.length > 8) {
        recent.pop();
    }
    localStorage.setItem('rf_recent', JSON.stringify(recent));
}

// ==========================================
// DARK MODE THEME TOGGLE
// ==========================================
function initTheme() {
    const savedTheme = localStorage.getItem('rf_theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
}

function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('rf_theme', newTheme);
}
