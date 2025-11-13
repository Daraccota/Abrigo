<?php
// Conexão com o banco de dados
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica o ID
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID do morador não especificado.");
}

// Busca o idoso
$stmt = $conn->prepare("SELECT * FROM idosos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Morador não encontrado.");
}

$idoso = $result->fetch_assoc();
$stmt->close();
$conn->close();

$fotoPerfil = !empty($idoso['foto_perfil']) ? "uploads/perfil/" . htmlspecialchars($idoso['foto_perfil']) : "https://via.placeholder.com/150";
$fotosDiarias = json_decode($idoso['fotos_diarias'], true) ?? [];
$videos = json_decode($idoso['videos'], true) ?? [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo htmlspecialchars($idoso['nome']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            background: #d9cfc3;
            font-family: 'Poppins', sans-serif;
            color: #3a3a3a;
        }
        .container-perfil {
            max-width: 1000px;
            margin: 60px auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            padding: 40px;
            position: relative;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #656263ff, #242e35ff);
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        .navbar-custom a {
            color: #fff;
            font-weight: 500;
        }
        .navbar-custom .btn-voltar {
            background: #fff;
            color: #1976d2;
            font-weight: 600;
            border-radius: 50px;
            padding: 8px 18px;
            transition: all 0.3s ease;
        }
        .navbar-custom .btn-voltar:hover {
            background: #1565c0;
            color: #fff;
            transform: scale(1.05);
        }
        .foto-perfil {
            width: 180px;
            height: 180px;
            border-radius: 20px;
            object-fit: cover;
            border: 5px solid #2196f3;
            box-shadow: 0 4px 12px rgba(33,150,243,0.4);
            transition: transform 0.3s ease;
        }
        .foto-perfil:hover {
            transform: scale(1.05);
        }
        .like-container {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.8);
            padding: 8px 15px;
            border-radius: 30px;
            /*  box-shadow: 0 3px 10px rgba(0,0,0,0.1); */
        }
        .heart-static {
            font-size: 2rem;
            color: #e91e63;
        }
        .like-count {
            font-weight: 600;
            color: #333;
        }
        .section {
            margin-top: 40px;
        }
        .section h2 {
            font-weight: 600;
            color: #1565c0;
            margin-bottom: 20px;
        }
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .media-grid img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .media-grid img:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }
        /* Novo estilo para vídeos de celular */
        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%; /* Proporção 16:9 */
            height: 0;
            overflow: hidden;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            background: #000;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .video-wrapper:hover {
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
            transform: scale(1.03);
        }
        .video-wrapper video {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        footer {
            text-align: center;
            margin-top: 60px;
            color: #777;
            font-size: 0.9rem;
        }
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-custom py-3 px-4">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="fw-bold text-white fs-4"><i class="bi bi-house-heart me-2"></i>Abrigo São Francisco</a>
        <a href="moradores_do_abrigo.php" class="btn btn-voltar"><i class="bi bi-arrow-left-circle me-1"></i> Voltar</a>
    </div>
</nav>

<!-- CONTEÚDO -->
<div class="container-perfil" data-aos="fade-up">
    <div class="like-container">
        <i class="bi bi-heart-fill heart-static"></i>
        <span class="like-count"><?php echo $idoso['likes']; ?></span>
    </div>

    <div class="profile-header d-flex align-items-center gap-4 flex-wrap">
        <img src="<?php echo $fotoPerfil; ?>" alt="Foto de <?php echo htmlspecialchars($idoso['nome']); ?>" class="foto-perfil" data-aos="zoom-in">
        <div class="profile-info" data-aos="fade-left">
            <h2 class="fw-bold mb-2"><?php echo htmlspecialchars($idoso['nome']); ?></h2>
            <p><strong>Idade:</strong> <?php echo htmlspecialchars($idoso['idade']); ?> anos</p>
            <p><strong>Cidade:</strong> <?php echo htmlspecialchars($idoso['cidade_de_origem']); ?></p>
            <p><strong>Data de Cadastro:</strong> <?php echo date("d/m/Y", strtotime($idoso['criado_em'])); ?></p>
            <p><strong>Bio:</strong> <?php echo htmlspecialchars($idoso['bio']); ?></p>
        </div>
    </div>

    <?php if (!empty($fotosDiarias)): ?>
    <div class="section" data-aos="fade-up">
        <h2><i class="bi bi-images me-2"></i>Fotos do Dia a Dia</h2>
        <div class="media-grid">
            <?php foreach ($fotosDiarias as $foto): ?>
                <img src="uploads/fotos/<?php echo htmlspecialchars($foto); ?>" alt="Foto diária">
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($videos)): ?>
    <div class="section" data-aos="fade-up">
        <h2><i class="bi bi-camera-reels me-2"></i>Vídeos do Dia a Dia</h2>
        <div class="media-grid">
            <?php foreach ($videos as $video): ?>
                <div class="video-wrapper">
                    <video src="uploads/videos/<?php echo htmlspecialchars($video); ?>" controls></video>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> - Abrigo São Francisco de Assis | Todos os direitos reservados.</p>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>

</body>
</html>
