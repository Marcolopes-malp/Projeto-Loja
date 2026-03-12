<?php
// Substitua as informações abaixo pelas que você acabou de criar no cPanel
$host = 'localhost'; // O pulo do gato: na HostGator, o host continua sendo localhost!
$dbname = 'marc7906_Loja'; // Coloque o nome completo do banco
$user = 'marc7906_admin';  // Coloque o nome completo do usuário
$pass = "Jm@13092018"; // A senha que você gerou lá no passo 4

try {
    // Tenta fazer a conexão
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Configura para mostrar os erros caso algo dê errado
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Teste rápido (descomente a linha abaixo para testar, depois apague)
    // echo "Conectado na nuvem com sucesso!"; 
    
} catch (PDOException $e) {
    // Se der erro, ele avisa e para o site
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>