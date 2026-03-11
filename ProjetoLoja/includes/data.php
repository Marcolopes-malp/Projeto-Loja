<?php
$placeholder_img = 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-card-40-iphone15hero-202309_FMT_WHH?wid=508&hei=472&fmt=p-jpg&qlt=95&.v=1693086290559';

function get_img($path)
{
    global $placeholder_img;

    // Se o usuário colocou um link direto da internet (http/https), retorna o link
    if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
        return $path;
    }

    // Se for um arquivo local, verifica se ele de fato existe na pasta
    if (file_exists(dirname(__DIR__) . '/' . $path)) {
        return '/ProjetoLoja/ProjetoLoja/' . $path;
    }

    // Caso contrário, mostra o placeholder padrão testando a loja
    return $placeholder_img;
}

$img_iphone17_pro_max_256gb = get_img("https://media.gettyimages.com/id/2243457933/pt/foto/brand-new-iphone-17-pro-max-in-cosmic-orange-on-white-background.jpg?s=612x612&w=0&k=20&c=94Awwt073RaRl5G1wzrcDZTr-lNR_NWdJHzwosg3cBY=");
$img_iphone17_pro_512gb = get_img("assets/img/iphone17_pro_512gb.jpg");
$img_iphone17_pro_256gb = get_img("assets/img/iphone17_pro_256gb.jpg");
$img_iphone17_256gb = get_img("assets/img/iphone17_256gb.jpg");
$img_iphone16_128gb = get_img("assets/img/iphone16_128gb.jpg");
$img_iphone15_128gb = get_img("assets/img/iphone15_128gb.jpg");
$img_iphone13_128gb = get_img("assets/img/iphone13_128gb.jpg");
$img_iphone16_pro_max_256gb = get_img("assets/img/iphone16_pro_max_256gb_semi.jpg");
$img_iphone16_pro_128gb = get_img("assets/img/iphone16_pro_128gb_semi.jpg");
$img_iphone16_128gb_semi = get_img("assets/img/iphone16_128gb_semi.jpg");
$img_iphone15_pro_max_256gb = get_img("assets/img/iphone15_pro_max_256gb_semi.jpg");
$img_iphone15_pro_256gb = get_img("assets/img/iphone15_pro_256gb_semi.jpg");
$img_iphone15_pro_128gb = get_img("assets/img/iphone15_pro_128gb_semi.jpg");
$img_iphone15_128gb_semi = get_img("assets/img/iphone15_128gb_semi.jpg");
$img_iphone14_pro_max_256gb = get_img("assets/img/iphone14_pro_max_256gb_semi.jpg");
$img_iphone14_pro_max_128gb = get_img("assets/img/iphone14_pro_max_128gb_semi.jpg");
$img_iphone14_pro_256gb = get_img("assets/img/iphone14_pro_256gb_semi.jpg");
$img_iphone14_pro_128gb = get_img("assets/img/iphone14_pro_128gb_semi.jpg");
$img_iphone14_128gb_semi = get_img("assets/img/iphone14_128gb_semi.jpg");
$img_iphone13_pro_max_128gb = get_img("assets/img/iphone13_pro_max_128gb_semi.jpg");
$img_iphone13_pro_256gb = get_img("assets/img/iphone13_pro_256gb_semi.jpg");
$img_iphone13_pro_128gb = get_img("assets/img/iphone13_pro_128gb_semi.jpg");
$img_iphone13_128gb_semi = get_img("assets/img/iphone13_128gb_semi.jpg");
$img_iphone12_pro_256gb = get_img("assets/img/iphone12_pro_256gb_semi.jpg");
$img_iphone12_128gb_semi = get_img("assets/img/iphone12_128gb_semi.jpg");


$iphones = [
    // --- IPHONES LACRADOS ---
    // Série iPhone 17
    1 => [
        'id' => 1,
        'linha' => '17',
        'nome' => '17 Pro Max',
        'capacidade' => '512GB',
        'preco' => 10500.00,
        'condicao' => 'Novo na caixa',
        'garantia' => '1 Ano de Garantia Apple',
        'imagem_url' => $img_iphone17_pro_max_256gb ?? $placeholder_img,
        'descricao' => 'O iPhone 17 Pro Max redefine o desempenho com seu novo chip A19 Pro, estrutura em titânio e tela Super Retina XDR com ProMotion. Sistema de câmeras avançado com lente de 48MP.',

        // Basta adicionar essa nova chave com as fotos do carrossel:
        'imagens' => [
            get_img('assets/img/iphone17_frente.jpg'),
            get_img('assets/img/iphone17_costas.jpg'),
            'https://site.com/foto-da-caixa.jpg' // Pode ser link da internet também!
        ]
    ],
    2 => ['id' => 2, 'linha' => '17', 'nome' => '17 Pro Max', 'capacidade' => '256GB', 'preco' => 8750.00, 'condicao' => 'Novo na caixa', 'garantia' => '1 Ano de Garantia Apple', 'imagem_url' => $img_iphone17_pro_max_256gb ?? $placeholder_img, 'descricao' => 'O iPhone 17 Pro Max redefine o desempenho com seu novo chip A19 Pro, estrutura em titânio e tela Super Retina XDR com ProMotion. Sistema de câmeras avançado com lente de 48MP.'],
    3 => ['id' => 3, 'linha' => '17', 'nome' => '17 Pro', 'capacidade' => '512GB', 'preco' => 9350.00, 'condicao' => 'Novo na caixa', 'garantia' => '1 Ano de Garantia Apple', 'imagem_url' => $img_iphone17_pro_512gb ?? $placeholder_img, 'descricao' => 'O iPhone 17 Pro apresenta o poderoso chip A19 Pro, estrutura leve e resistente em titânio, além de um sistema de câmeras versátil de nível profissional e design refinado.'],
    4 => ['id' => 4, 'linha' => '17', 'nome' => '17 Pro', 'capacidade' => '256GB', 'preco' => 7990.00, 'condicao' => 'Novo na caixa', 'garantia' => '1 Ano de Garantia Apple', 'imagem_url' => $img_iphone17_pro_256gb ?? $placeholder_img, 'descricao' => 'O iPhone 17 Pro apresenta o poderoso chip A19 Pro, estrutura leve e resistente em titânio, além de um sistema de câmeras versátil de nível profissional e design refinado.'],
    5 => ['id' => 5, 'linha' => '17', 'nome' => '17', 'capacidade' => '256GB', 'preco' => 5990.00, 'condicao' => 'Novo na caixa', 'garantia' => '1 Ano de Garantia Apple', 'imagem_url' => $img_iphone17_256gb ?? $placeholder_img, 'descricao' => 'O iPhone 17 traz o chip A18, tela OLED de alta qualidade. Fotos com definição impressionante usando a câmera principal de 48MP.'],

    // Modelos Selecionados
    6 => ['id' => 6, 'linha' => '16', 'nome' => '16', 'capacidade' => '128GB', 'preco' => 4990.00, 'condicao' => 'Novo na caixa', 'garantia' => '1 Ano de Garantia Apple', 'imagem_url' => $img_iphone16_128gb ?? $placeholder_img, 'descricao' => 'Com o chip A18, o iPhone 16 entrega ótima performance e um design inovador. Controle de câmera aprimorado e suporte a recursos avançados de fotografia.'],
    7 => ['id' => 7, 'linha' => '15', 'nome' => '15', 'capacidade' => '128GB', 'preco' => 4150.00, 'condicao' => 'Novo na caixa', 'garantia' => '1 Ano de Garantia Apple', 'imagem_url' => $img_iphone15_128gb ?? $placeholder_img, 'descricao' => 'O iPhone 15 introduz a Dynamic Island na linha base, câmera grande-angular de 48 MP e o versátil conector USB-C, combinado ao chassi de bordas arredondadas.'],
    8 => ['id' => 8, 'linha' => '13', 'nome' => '13', 'capacidade' => '128GB', 'preco' => 3590.00, 'condicao' => 'Novo na caixa', 'garantia' => '1 Ano de Garantia Apple', 'imagem_url' => $img_iphone13_128gb ?? $placeholder_img, 'descricao' => 'Foco em duração de bateria, chip A15 bionic ultra-rápido, e o adorado Modo Cinema que muda o foco automaticamente nos seus vídeos.'],

    // --- IPHONES SEMINOVOS PREMIUM ---
    // Linha 16
    9 => ['id' => 9, 'linha' => '16', 'nome' => '16 Pro Max', 'capacidade' => '256GB', 'preco' => 5690.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone16_pro_max_256gb ?? $placeholder_img, 'descricao' => 'O iPhone 16 Pro Max apresenta o poderoso chip A18 Pro, estrutura leve e resistente em titânio, além de um sistema de câmeras versátil de nível profissional com amplo armazenamento.'],
    10 => ['id' => 10, 'linha' => '16', 'nome' => '16 Pro', 'capacidade' => '128GB', 'preco' => 5050.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone16_pro_128gb ?? $placeholder_img, 'descricao' => 'O iPhone 16 Pro garante alto desempenho com o chip A18 Pro. A sua estrutura de titânio o torna extremamente durável, além de muito elegante.'],
    11 => ['id' => 11, 'linha' => '16', 'nome' => '16', 'capacidade' => '128GB', 'preco' => 4350.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone16_128gb_semi ?? $placeholder_img, 'descricao' => 'Excelente custo-benefício. Este iPhone 16 une a modernidade do Controle de câmera as vantagens do iOS perfeitamente fluido e otimizado.'],

    // Linha 15
    12 => ['id' => 12, 'linha' => '15', 'nome' => '15 Pro Max', 'capacidade' => '256GB', 'preco' => 4600.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone15_pro_max_256gb ?? $placeholder_img, 'descricao' => 'Equipado com o chip A17 Pro, design em titânio impressionantemente leve. Oferece o zoom óptico mais potente já visto num iPhone até sua geração.'],
    13 => ['id' => 13, 'linha' => '15', 'nome' => '15 Pro', 'capacidade' => '256GB', 'preco' => 4150.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone15_pro_256gb ?? $placeholder_img, 'descricao' => 'Equipado com o chip A17 Pro para um nível de desempenho sem precedentes em jogos e fluidez. Design de titânio aeroespacial e suporte robusto para fotografias incríveis.'],
    14 => ['id' => 14, 'linha' => '15', 'nome' => '15 Pro', 'capacidade' => '128GB', 'preco' => 3990.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone15_pro_128gb ?? $placeholder_img, 'descricao' => 'Compacto e poderoso. O iPhone 15 Pro de 128GB traz as incríveis texturas de titânio, chip avançado e botões personalizáveis de Ação.'],
    15 => ['id' => 15, 'linha' => '15', 'nome' => '15', 'capacidade' => '128GB', 'preco' => 3350.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone15_128gb_semi ?? $placeholder_img, 'descricao' => 'O iPhone 15 introduz a Dynamic Island de série, câmera principal de 48 MP e conector USB-C. Traz cores fantásticas com vidro traseiro colorido.'],

    // Linha 14
    16 => ['id' => 16, 'linha' => '14', 'nome' => '14 Pro Max', 'capacidade' => '256GB', 'preco' => 4150.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone14_pro_max_256gb ?? $placeholder_img, 'descricao' => 'A estreia da super útil Dynamic Island e câmera principal de 48 MP. Traz o processador A16 Bionic entregando uma bateria fabulosa.'],
    17 => ['id' => 17, 'linha' => '14', 'nome' => '14 Pro Max', 'capacidade' => '128GB', 'preco' => 3790.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone14_pro_max_128gb ?? $placeholder_img, 'descricao' => 'Tela expansiva com excelente imersão em conteúdo com a proteção robusta do Ceramic Shield. Bateria incrível com processamento excepcional A16 Bionic.'],
    18 => ['id' => 18, 'linha' => '14', 'nome' => '14 Pro', 'capacidade' => '256GB', 'preco' => 3490.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone14_pro_256gb ?? $placeholder_img, 'descricao' => 'A combinação perfeita entre portabilidade e qualidade profissional. O 14 Pro traz a Dynamic Island, 48 MP num visual de tirar o fôlego.'],
    19 => ['id' => 19, 'linha' => '14', 'nome' => '14 Pro', 'capacidade' => '128GB', 'preco' => 3350.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone14_pro_128gb ?? $placeholder_img, 'descricao' => 'Projetado para inovar. Câmeras capazes de registrar o dobro de resolução em condições adversas de iluminação graças à tecnologia pioneira deste modelo.'],
    20 => ['id' => 20, 'linha' => '14', 'nome' => '14', 'capacidade' => '128GB', 'preco' => 2750.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone14_128gb_semi ?? $placeholder_img, 'descricao' => 'O que importa está aqui: bateria para o dia todo, detecção de acidente e sistema de câmera dupla espetacular. Um companheiro para qualquer hora.'],

    // Linha 13 & 12
    21 => ['id' => 21, 'linha' => '13', 'nome' => '13 Pro Max', 'capacidade' => '128GB', 'preco' => 3300.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone13_pro_max_128gb ?? $placeholder_img, 'descricao' => 'Considerado um dos maiores campeões de bateria da Apple, este modelo traz tela Super Retina XDR imersiva e câmeras excepcionais inclusive a noite.'],
    22 => ['id' => 22, 'linha' => '13', 'nome' => '13 Pro', 'capacidade' => '256GB', 'preco' => 3150.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone13_pro_256gb ?? $placeholder_img, 'descricao' => 'O 13 Pro oferece o adorado modo ProMotion (120 Hz) em um fator de forma ergonômico. Equipado com chip A15 ultrarrápido.'],
    23 => ['id' => 23, 'linha' => '13', 'nome' => '13 Pro', 'capacidade' => '128GB', 'preco' => 2990.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone13_pro_128gb ?? $placeholder_img, 'descricao' => 'Velocidade e conforto ao seu dispor. Ótima performance em jogos, fluidez sem igual e um conjunto triplo que grava fotos profissionais.'],
    24 => ['id' => 24, 'linha' => '13', 'nome' => '13', 'capacidade' => '128GB', 'preco' => 2550.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone13_128gb_semi ?? $placeholder_img, 'descricao' => 'O formato queridinho. Câmeras arranjadas em diagonal que revolucionaram, alta durabilidade graças ao escudo de cerâmica e resistência a água.'],
    25 => ['id' => 25, 'linha' => '12', 'nome' => '12 Pro', 'capacidade' => '256GB', 'preco' => 2390.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone12_pro_256gb ?? $placeholder_img, 'descricao' => 'Estrutura premium em aço inoxidável e a tecnologia 5G da maçã. Chip A14 altamente otimizado para lidar com realidade aumentada e ótimos registros.', 'estoque' => 2],
    26 => ['id' => 26, 'linha' => '12', 'nome' => '12', 'capacidade' => '128GB', 'preco' => 2100.00, 'condicao' => 'Seminovo Premium', 'garantia' => '3 Meses de Garantia', 'imagem_url' => $img_iphone12_128gb_semi ?? $placeholder_img, 'descricao' => 'Bordas planas, conectividade de ponta. Perfeito para entrar na era das redes modernas com qualidade Apple e ótima reprodução de cores na tela OLED.', 'estoque' => 10],
];

// Cupons de desconto simulados (porcentagem)
$cupons_validos = [
    'PROMO10' => 10,
    'APPLE5' => 5,
    'BEMVINDO' => 15
];

// Avaliações Falsas Mocks
$avaliacoes = [
    ['nome' => 'Carlos M.', 'texto' => 'Aparelho chegou impecável! Recomendo muito a RFIphones.', 'estrelas' => 5],
    ['nome' => 'Ana P.', 'texto' => 'Atendimento excelente pelo WhatsApp, tiraram todas as minhas dúvidas.', 'estrelas' => 5],
    ['nome' => 'João V.', 'texto' => 'Comprei um 14 Pro Max seminovo e parece que saiu da caixa hoje. Perfeito.', 'estrelas' => 5]
];
?>
