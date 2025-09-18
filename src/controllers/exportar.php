<?php
// exportar.php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$tipo = $_GET['tipo'] ?? '';

// ======================
// EXPORTAR COMO iCal (.ics)
// ======================
if ($tipo === 'ical') {
    header('Content-type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename=eventos.ics');

    echo "BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//SeuProjeto//PT\n";

    $sql = "SELECT * FROM eventos ORDER BY data ASC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $dtstart = date("Ymd\THis", strtotime($row['data'] . " " . $row['hora']));
        $dtend   = date("Ymd\THis", strtotime($row['data'] . " " . $row['hora'] . " +1 hour"));
        $uid     = uniqid();
        echo "BEGIN:VEVENT\n";
        echo "UID:$uid\n";
        echo "DTSTAMP:" . gmdate("Ymd\THis\Z") . "\n";
        echo "DTSTART:$dtstart\n";
        echo "DTEND:$dtend\n";
        echo "SUMMARY:" . $row['titulo'] . "\n";
        echo "CATEGORIES:" . $row['tipo'] . "\n";
        echo "END:VEVENT\n";
    }

    echo "END:VCALENDAR";
    exit;
}

// ======================
// EXPORTAR COMO CSV (.csv)
// ======================
if ($tipo === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=eventos.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Data', 'Hora', 'Evento', 'Tipo']);

    $sql = "SELECT * FROM eventos ORDER BY data ASC, hora ASC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            date("d/m/Y", strtotime($row['data'])),
            date("H:i", strtotime($row['hora'])),
            $row['titulo'],
            $row['tipo']
        ]);
    }

    fclose($output);
    exit;
}

// ======================
// EXPORTAR COMO PDF (.pdf)

// Se quiser!
// ======================


$conn->close();
?>
