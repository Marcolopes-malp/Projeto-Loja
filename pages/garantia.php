<?php
require_once dirname(__DIR__) . '/includes/config.php';

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="container" style="padding: 60px 0; max-width: 800px; min-height: 50vh;">
    <h1 style="font-size: 2.5rem; margin-bottom: 24px;">Garantia e Suporte</h1>
    <p style="font-size: 1.1rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 24px;">
        Todos os nossos aparelhos seminovos passam por uma rigorosa avaliação técnica e possuem <strong>3 meses de garantia</strong> balcão para defeitos de fabricação (não cobre mau uso).<br><br>
        Os aparelhos lacrados acompanham a garantia oficial de <strong>1 ano da Apple</strong> e podem ser acionados em qualquer autorizada no Brasil.
    </p>
    <a href="<?= BASE_URL ?>/index.php" class="btn btn-outline" style="border-radius: 980px;">Voltar ao início</a>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
