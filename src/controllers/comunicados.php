<?php
// comunicados.php

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

// Conectar ao banco
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// Capturar dados do formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mensagem = $conn->real_escape_string($_POST['mensagem']);
    $acao     = $_POST['acao'];

    if ($acao === "publicar") {
        $tipo = "publicado";
        $data_publicacao = date("Y-m-d H:i:s"); // agora
    } else {
        $tipo = "agendado";
        // Exemplo: agenda para daqui 1 dia
        $data_publicacao = date("Y-m-d H:i:s", strtotime("+1 day"));
    }

    $sql = "INSERT INTO comunicados (mensagem, tipo, data_publicacao) 
            VALUES ('$mensagem', '$tipo', '$data_publicacao')";

    if ($conn->query($sql) === TRUE) {
        echo "Comunicado registrado com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }
}

$conn->close();

// Redirecionar de volta para a página principal
header("Location: ../views/pages/ADMpage.php");
exit;
?>
