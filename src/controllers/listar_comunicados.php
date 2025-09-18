<?php
// listar_comunicados.php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$sql = "SELECT id, mensagem, tipo, data_publicacao 
        FROM comunicados 
        ORDER BY data_publicacao DESC 
        LIMIT 5"; // mostra os últimos 5

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='alert alert-info d-flex justify-content-between align-items-center' style='margin:5px 0;'>";
        echo "<div>";
        echo "<strong>" . ucfirst($row['tipo']) . ":</strong> ";
        echo htmlspecialchars($row['mensagem']) . " ";
        echo "<em>(" . date("d/m/Y H:i", strtotime($row['data_publicacao'])) . ")</em>";
        echo "</div>";
        
        // Botão de excluir
        echo "<form method='POST' action='../../controllers/excluir_comunicado.php' style='margin:0;'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<button type='submit' class='btn btn-danger btn-sm' onclick=\"return confirm('Tem certeza que deseja excluir este comunicado?');\">Excluir</button>";
        echo "</form>";

        echo "</div>";
    }
} else {
    echo "Nenhuma mensagem publicada ainda.";
}

$conn->close();
?>
