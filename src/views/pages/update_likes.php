<?php
// update_likes.php

// Configurações do banco de dados
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

// Conecta ao banco
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die(json_encode(['status' => 'erro', 'mensagem' => 'Erro na conexão: ' . $conn->connect_error]));
}

// Recebe dados do POST
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$action  = $_POST['action'] ?? '';

if ($user_id <= 0 || !in_array($action, ['like', 'unlike'])) {
    die(json_encode(['status' => 'erro', 'mensagem' => 'Parâmetros inválidos']));
}

// Primeiro, pega o número atual de likes
$sql = "SELECT likes FROM idosos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($likes);
if (!$stmt->fetch()) {
    $stmt->close();
    $conn->close();
    die(json_encode(['status' => 'erro', 'mensagem' => 'Morador não encontrado']));
}
$stmt->close();

// Atualiza o número de likes
if ($action === 'like') {
    $likes++;
} else {
    $likes = max(0, $likes - 1); // garante que não fique negativo
}

$update = $conn->prepare("UPDATE idosos SET likes = ? WHERE id = ?");
$update->bind_param("ii", $likes, $user_id);
if ($update->execute()) {
    echo json_encode(['status' => 'sucesso', 'likes' => $likes]);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao atualizar likes']);
}

$update->close();
$conn->close();
