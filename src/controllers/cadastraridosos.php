<?php
// controllers/cadastraridosos.php

// Aumentar limites de upload (tem que combinar com php.ini)
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
ini_set('max_input_time', '300');
ini_set('max_execution_time', '300');

// Função para converter valores do php.ini em bytes
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $val = (int)$val;
    switch($last) {
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
    }
    return $val;
}

// Verificar se o POST excedeu o limite
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postMaxBytes = return_bytes(ini_get('post_max_size'));
    if ($_SERVER['CONTENT_LENGTH'] > $postMaxBytes) {
        echo "<script>alert('O tamanho do upload é muito grande. Reduza o tamanho do vídeo e tente novamente.'); window.history.back();</script>";
        exit;
    }
}

// Configurações do banco de dados
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

// Conectar ao banco
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("<script>alert('Erro na conexão com o banco de dados.'); window.history.back();</script>");
}

// Criar diretórios de upload caso não existam
$uploadBase = __DIR__ . '/../views/pages/uploads/';
$dirs = ['perfil', 'fotos', 'videos'];
foreach ($dirs as $dir) {
    if (!is_dir($uploadBase . $dir)) {
        mkdir($uploadBase . $dir, 0777, true);
    }
}

// Receber dados do formulário
$nome             = $_POST['nome'] ?? null;
$idade            = $_POST['idade'] ?? null;
$cidade_de_origem = $_POST['cidade_de_origem'] ?? null;
$bio              = $_POST['bio'] ?? null;

// Validar campos essenciais
if (empty($nome) || empty($idade)) {
    echo "<script>alert('Nome e idade são obrigatórios.'); window.history.back();</script>";
    exit;
}

// --- Função para upload seguro ---
function uploadArquivo($file, $diretorio, $prefixo, $maxSizeMB = 50) {
    $tamanhoMax = $maxSizeMB * 1024 * 1024;

    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return null; // Nenhum arquivo enviado
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Erro ao enviar arquivo: " . $file['name']);
    }

    if ($file['size'] > $tamanhoMax) {
        throw new Exception("O arquivo " . $file['name'] . " excede o tamanho máximo de {$maxSizeMB}MB.");
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $novoNome = uniqid($prefixo . '_') . "." . $ext;
    $destino = $diretorio . $novoNome;

    if (!move_uploaded_file($file['tmp_name'], $destino)) {
        throw new Exception("Falha ao mover o arquivo " . $file['name']);
    }

    return $novoNome;
}

// --- Upload da foto de perfil ---
try {
    $fotoPerfilNome = !empty($_FILES['foto_perfil']['name']) 
        ? uploadArquivo($_FILES['foto_perfil'], $uploadBase . "perfil/", "perfil", 5) // 5MB para perfil
        : null;
} catch (Exception $e) {
    echo "<script>alert('Erro na foto de perfil: " . $e->getMessage() . "'); window.history.back();</script>";
    exit;
}

// --- Upload de fotos diárias ---
$fotosDiarias = [];
if (!empty($_FILES['fotos_diarias']['name'][0])) {
    foreach ($_FILES['fotos_diarias']['tmp_name'] as $key => $tmp_name) {
        try {
            $fotosDiarias[] = uploadArquivo([
                'name' => $_FILES['fotos_diarias']['name'][$key],
                'tmp_name' => $tmp_name,
                'size' => $_FILES['fotos_diarias']['size'][$key],
                'error' => $_FILES['fotos_diarias']['error'][$key]
            ], $uploadBase . "fotos/", "foto", 10); // 10MB por foto
        } catch (Exception $e) {
            echo "<script>alert('Erro na foto: " . $e->getMessage() . "'); window.history.back();</script>";
            exit;
        }
    }
}

// --- Upload de vídeos ---
$videos = [];
if (!empty($_FILES['videos']['name'][0])) {
    foreach ($_FILES['videos']['tmp_name'] as $key => $tmp_name) {
        try {
            $videos[] = uploadArquivo([
                'name' => $_FILES['videos']['name'][$key],
                'tmp_name' => $tmp_name,
                'size' => $_FILES['videos']['size'][$key],
                'error' => $_FILES['videos']['error'][$key]
            ], $uploadBase . "videos/", "video", 40); // 40MB por vídeo
        } catch (Exception $e) {
            echo "<script>alert('Erro no vídeo: " . $e->getMessage() . "'); window.history.back();</script>";
            exit;
        }
    }
}

// Converter arrays em JSON para salvar no banco
$fotosJson  = json_encode($fotosDiarias, JSON_UNESCAPED_UNICODE);
$videosJson = json_encode($videos, JSON_UNESCAPED_UNICODE);

// Inserir no banco
$sql = "INSERT INTO idosos (nome, idade, cidade_de_origem, bio, foto_perfil, fotos_diarias, videos) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sisssss",
    $nome,
    $idade,
    $cidade_de_origem,
    $bio,
    $fotoPerfilNome,
    $fotosJson,
    $videosJson
);

if ($stmt->execute()) {
    echo "<script>alert('Idoso cadastrado com sucesso!'); window.history.back();</script>";
} else {
    echo "<script>alert('Erro ao cadastrar idoso: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
