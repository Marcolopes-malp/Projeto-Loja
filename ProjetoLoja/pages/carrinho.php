<?php
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/data.php';

// Busca os itens do carrinho na sessão
$itens_carrinho = $_SESSION['carrinho'] ?? [];

$total_carrinho = 0;
$produtos_no_carrinho = [];

// Prepara os dados para exibição
foreach ($itens_carrinho as $item_sessao) {
    if (isset($iphones[$item_sessao['id']])) {
        $produto = $iphones[$item_sessao['id']];
        $produto['quantidade_carrinho'] = $item_sessao['quantidade'];
        $produto['subtotal'] = $produto['preco'] * $produto['quantidade_carrinho'];
        $total_carrinho += $produto['subtotal'];
        $produtos_no_carrinho[] = $produto;
    }
}

// Lógica de Desconto (Cupom)
$desconto_percentual = 0;
$desconto_valor = 0;
$cupom_aplicado = $_SESSION['cupom'] ?? '';

if (!empty($cupom_aplicado) && isset($cupons_validos[$cupom_aplicado])) {
    $desconto_percentual = $cupons_validos[$cupom_aplicado];
    $desconto_valor = ($total_carrinho * $desconto_percentual) / 100;
}

// Lógica de Frete Simulado
$frete_valor = $_SESSION['frete_valor'] ?? 0;
$cep_simulado = $_SESSION['cep_simulado'] ?? '';

$total_final = $total_carrinho - $desconto_valor + $frete_valor;

// Gera a mensagem para o WhatsApp com todos os itens se for finalizar
$mensagem_whats = "Olá! Gostaria de finalizar a compra dos seguintes itens do meu carrinho:\n\n";
foreach ($produtos_no_carrinho as $prod) {
    $mensagem_whats .= "- " . $prod['quantidade_carrinho'] . "x iPhone " . $prod['nome'] . " (" . $prod['capacidade'] . ") - R$ " . number_format($prod['subtotal'], 2, ',', '.') . "\n";
}

if ($desconto_valor > 0) {
    $mensagem_whats .= "\nCupom aplicado: " . $cupom_aplicado . " (- R$ " . number_format($desconto_valor, 2, ',', '.') . ")";
}
if ($frete_valor > 0) {
    $mensagem_whats .= "\nFrete Simulado: R$ " . number_format($frete_valor, 2, ',', '.') . " (CEP: $cep_simulado)";
} else {
    $mensagem_whats .= "\nFrete: Grátis";
}

$mensagem_whats .= "\n\n*Total a Pagar: R$ " . number_format($total_final, 2, ',', '.') . "*\n\nComo podemos prosseguir?";
$url_whatsapp = "https://wa.me/5511993259396?text=" . urlencode($mensagem_whats);

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="container" style="padding-top: 40px; padding-bottom: 60px; min-height: 60vh;">
    
    <div class="breadcrumb" style="padding-top: 0; padding-bottom: 24px;">
        <a href="../index.php">Início</a>
        <span class="breadcrumb-separator">&rsaquo;</span>
        <span style="color: var(--text-main);">Carrinho de Compras</span>
    </div>

    <h1 style="font-size: 2.2rem; margin-bottom: 30px;">Seu Carrinho</h1>

    <?php if (empty($produtos_no_carrinho)): ?>
        <div style="background: var(--card-bg); border-radius: 24px; padding: 60px 20px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--border-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 20px;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <h2 style="font-size: 1.5rem; margin-bottom: 12px;">Seu carrinho está vazio</h2>
            <p style="color: var(--text-secondary); margin-bottom: 30px;">Adicione alguns dos nossos aparelhos ao seu carrinho para poder prosseguir.</p>
            <a href="../index.php" class="btn btn-primary" style="padding: 14px 30px;">Continuar Comprando</a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 40px; align-items: start;">
            
            <!-- Lista de Produtos -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <?php foreach ($produtos_no_carrinho as $produto): ?>
                    <div style="background: var(--card-bg); border-radius: 16px; padding: 20px; display: flex; gap: 24px; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        
                        <div style="width: 100px; height: 100px; border-radius: 12px; background: #f5f5f7; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden;">
                            <img src="<?= htmlspecialchars($produto['imagem_url']) ?>" alt="iPhone" style="max-width: 80%; max-height: 80%; object-fit: contain;">
                        </div>
                        
                        <div style="flex-grow: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <div>
                                    <h3 style="font-size: 1.2rem; margin-bottom: 4px;">iPhone <?= htmlspecialchars($produto['nome']) ?></h3>
                                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 12px;">
                                        <?= htmlspecialchars($produto['capacidade']) ?> &bull; <?= htmlspecialchars($produto['condicao']) ?>
                                    </p>
                                </div>
                                <div style="text-align: right;">
                                    <p style="font-weight: 600; font-size: 1.1rem;">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                                </div>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <form method="POST" action="../pages/carrinho_acao.php" style="display: flex; align-items: center; gap: 10px; background: var(--bg-color); padding: 4px; border-radius: 8px;">
                                    <input type="hidden" name="acao" value="update">
                                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                    <button type="submit" name="qtde" value="<?= $produto['quantidade_carrinho'] - 1 ?>" style="background: none; border: none; cursor: pointer; padding: 4px 10px; font-size: 1.1rem; color: var(--text-main);">-</button>
                                    <span style="font-weight: 500; min-width: 20px; text-align: center;"><?= $produto['quantidade_carrinho'] ?></span>
                                    <button type="submit" name="qtde" value="<?= $produto['quantidade_carrinho'] + 1 ?>" style="background: none; border: none; cursor: pointer; padding: 4px 10px; font-size: 1.1rem; color: var(--text-main);">+</button>
                                </form>
                                
                                <form method="POST" action="../pages/carrinho_acao.php">
                                    <input type="hidden" name="acao" value="remove">
                                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                    <button type="submit" style="background: none; border: none; cursor: pointer; color: #E53935; font-size: 0.95rem; font-weight: 500; text-decoration: underline;">Remover</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Resumo do Pedido -->
            <div style="background: var(--card-bg); border-radius: 24px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); position: sticky; top: 100px;">
                <h2 style="font-size: 1.4rem; margin-bottom: 24px;">Resumo do Pedido</h2>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 1rem; color: var(--text-secondary);">
                    <span>Subtotal</span>
                    <span>R$ <?= number_format($total_carrinho, 2, ',', '.') ?></span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 1rem; color: var(--text-secondary);">
                    <span>Frete Expresso</span>
                    <?php if ($frete_valor > 0): ?>
                        <span style="color: var(--text-main); font-weight: 500;">R$ <?= number_format($frete_valor, 2, ',', '.') ?> <small style="color:var(--text-secondary);">(<?= htmlspecialchars($cep_simulado) ?>)</small></span>
                    <?php else: ?>
                        <span style="color: #34C759; font-weight: 500;">Grátis</span>
                    <?php endif; ?>
                </div>

                <?php if ($desconto_valor > 0): ?>
                <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 1rem; color: #34C759;">
                    <span>Desconto (<?= htmlspecialchars($cupom_aplicado) ?>)</span>
                    <span style="font-weight: 500;">- R$ <?= number_format($desconto_valor, 2, ',', '.') ?></span>
                </div>
                <?php else: ?>
                    <div style="margin-bottom: 24px;"></div>
                <?php endif; ?>

                <!-- Simulador de Frete -->
                <form method="POST" action="../pages/carrinho_acao.php" style="display: flex; gap: 8px; margin-bottom: 12px;">
                    <input type="hidden" name="acao" value="simular_frete">
                    <input type="text" name="cep" placeholder="Simular CEP" required maxlength="9" style="flex: 1; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem;">
                    <button type="submit" class="btn btn-secondary" style="padding: 0 16px; border-radius: 8px;">OK</button>
                </form>

                <!-- Cupom de Desconto -->
                <form method="POST" action="../pages/carrinho_acao.php" style="display: flex; gap: 8px; margin-bottom: 24px;">
                    <input type="hidden" name="acao" value="aplicar_cupom">
                    <input type="text" name="cupom" placeholder="Cupom de desconto" value="<?= htmlspecialchars($cupom_aplicado) ?>" style="flex: 1; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem; text-transform: uppercase;">
                    <button type="submit" class="btn btn-secondary" style="padding: 0 16px; border-radius: 8px;">Usar</button>
                </form>
                
                <div style="border-top: 1px solid var(--border-color); padding-top: 24px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: baseline;">
                    <span style="font-weight: 600; font-size: 1.2rem;">Total</span>
                    <span style="font-weight: 700; font-size: 1.6rem;">R$ <?= number_format($total_final, 2, ',', '.') ?></span>
                </div>
                
                <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 24px; text-align: center;">
                    Pagamento à vista no Pix ou até 12x com juros da administradora.
                </p>

                <a href="<?= htmlspecialchars($url_whatsapp) ?>" target="_blank" class="btn btn-primary btn-block" style="padding: 18px; font-size: 1.1rem; display: flex; justify-content: center; align-items: center; gap: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    Finalizar no WhatsApp
                </a>
            </div>

        </div>
    <?php endif; ?>

</div>

<style>
/* Responsive layout form Mobile Cart */
@media (max-width: 900px) {
    .container > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
}
@media (max-width: 500px) {
    .container > div > div > div[style*="display: flex; gap: 24px;"] {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
