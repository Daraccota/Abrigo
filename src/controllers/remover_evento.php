<?php
// remover_evento.php
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
    $conn->query("DELETE FROM eventos WHERE id=$id");
}

$conn->close();
header("Location: ../views/pages/ADMpage.php");
exit;
?>
