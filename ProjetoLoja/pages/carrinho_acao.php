<?php
session_start();
require_once dirname(__DIR__) . '/includes/data.php';

// Initialize the cart in the session if it doesn't exist
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($acao === 'add' && $id > 0) {
    // Check if item exists in store
    if (isset($iphones[$id])) {
        // Find if already in cart
        $encontrado = false;
        foreach ($_SESSION['carrinho'] as $index => $item) {
            if ($item['id'] == $id) {
                // Increment logic
                $_SESSION['carrinho'][$index]['quantidade']++;
                $encontrado = true;
                break;
            }
        }
        
        // Add new item if not found
        if (!$encontrado) {
            $_SESSION['carrinho'][] = [
                'id' => $id,
                'quantidade' => 1
            ];
        }
    }
    // Return to the previous page (details or shop) or to cart
    header("Location: ../pages/carrinho.php");
    exit;
}

if ($acao === 'remove' && $id > 0) {
    // Remove item from cart
    foreach ($_SESSION['carrinho'] as $index => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['carrinho'][$index]);
            // Re-index array so we don't end up with gaps that break foreach loops easily
            $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
            break;
        }
    }
    // Return to cart page
    header("Location: ../pages/carrinho.php");
    exit;
}

if ($acao === 'update' && $id > 0 && isset($_POST['qtde'])) {
    $qtde = (int)$_POST['qtde'];
    
    if ($qtde <= 0) {
        // If qty 0 or less, remove it
        foreach ($_SESSION['carrinho'] as $index => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION['carrinho'][$index]);
                $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
                break;
            }
        }
    } else {
        // Update quantity
        foreach ($_SESSION['carrinho'] as $index => $item) {
            if ($item['id'] == $id) {
                $_SESSION['carrinho'][$index]['quantidade'] = $qtde;
                break;
            }
        }
    }
    header("Location: ../pages/carrinho.php");
    exit;
}

if ($acao === 'simular_frete' && isset($_POST['cep'])) {
    $cep = preg_replace('/[^0-9]/', '', $_POST['cep']);
    if (strlen($cep) === 8) {
        // Lógica Fictícia de Frete Simulado (Se começar com 0 é grátis, senão R$ 35 a R$ 85)
        if ($cep[0] == '0' || $cep[0] == '1') {
            $_SESSION['frete_valor'] = 0; // Expresso Grátis SP
        } else {
            $_SESSION['frete_valor'] = rand(35, 85);
        }
        $_SESSION['cep_simulado'] = substr($cep, 0, 5) . '-' . substr($cep, 5);
    }
    header("Location: ../pages/carrinho.php");
    exit;
}

if ($acao === 'aplicar_cupom' && isset($_POST['cupom'])) {
    $cupom = strtoupper(trim($_POST['cupom']));
    $_SESSION['cupom'] = $cupom;
    header("Location: ../pages/carrinho.php");
    exit;
}

// Fallback redirect
header("Location: ../index.php");
exit;
