<?php
// excluir_comunicado.php

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM comunicados WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // sucesso
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
}

$conn->close();

// Redirecionar de volta
header("Location: ../views/pages/ADMpage.php");
exit;
?>
