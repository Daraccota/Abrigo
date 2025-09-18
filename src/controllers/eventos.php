<?php
// eventos.php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['acao'] === "adicionar") {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $data   = $_POST['data'];
    $hora   = $_POST['hora'];
    $tipo   = $conn->real_escape_string($_POST['tipo']);

    $sql = "INSERT INTO eventos (titulo, data, hora, tipo)
            VALUES ('$titulo', '$data', '$hora', '$tipo')";

    if ($conn->query($sql) === TRUE) {
        // sucesso
    } else {
        echo "Erro: " . $conn->error;
    }
}

$conn->close();
header("Location: ../views/pages/ADMpage.php");
exit;
?>
