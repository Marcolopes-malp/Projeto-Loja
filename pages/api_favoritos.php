<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/conexao.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Not logged in', 'action' => 'local']);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

if (!isset($dados['id_produto']) || !isset($dados['acao'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos']);
    exit;
}

$id_usuario = $_SESSION['user']['id'];
$id_produto = (int) $dados['id_produto'];
$acao = $dados['acao'];

try {
    if ($acao === 'add') {
        $stmt = $pdo->prepare("INSERT IGNORE INTO favoritos (id_usuario, id_produto) VALUES (?, ?)");
        $stmt->execute([$id_usuario, $id_produto]);
        echo json_encode(['sucesso' => true, 'acao' => 'add']);
    } elseif ($acao === 'remove') {
        $stmt = $pdo->prepare("DELETE FROM favoritos WHERE id_usuario = ? AND id_produto = ?");
        $stmt->execute([$id_usuario, $id_produto]);
        echo json_encode(['sucesso' => true, 'acao' => 'remove']);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Ação desconhecida']);
    }
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro interno']);
}
