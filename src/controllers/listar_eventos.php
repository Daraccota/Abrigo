<?php
// listar_eventos.php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$sql = "SELECT * FROM eventos ORDER BY data ASC, hora ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dataHora = date("d/m/Y", strtotime($row['data'])) . " " . date("H:i", strtotime($row['hora']));
        echo "<tr>";
        echo "<td>$dataHora</td>";
        echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
        echo "<td>
                <form action='../../controllers/remover_evento.php' method='POST' style='display:inline'>
                  <input type='hidden' name='id' value='" . $row['id'] . "'>
                  <button type='submit' class='btn danger' onclick=\"return confirm('Deseja excluir este evento?');\">Remover</button>
                </form>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Nenhum evento cadastrado.</td></tr>";
}

$conn->close();
?>
