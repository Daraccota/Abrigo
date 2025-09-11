<?php
// Configurações do banco de dados
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

// Conexão
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o ID foi passado
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID do morador não especificado.");
}

// Busca os dados do idoso
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

// Caminhos das imagens
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            position: relative;
        }
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #ddd;
        }
        .profile-info h1 {
            margin: 0;
            color: #2c3e50;
        }
        .profile-info p {
            margin: 5px 0;
            color: #555;
        }
        .like-container {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
        }
        .heart-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 28px;
            color: #ccc;
            transition: color 0.2s ease;
        }
        .heart-btn.liked {
            color: #e74c3c;
        }
        .like-count {
            margin-left: 8px;
            font-weight: bold;
            color: #555;
            font-size: 1.1em;
        }
        .section {
            margin-top: 30px;
        }
        .section h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        .photos, .videos {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .photos img, .videos video {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="like-container">
        <button class="heart-btn <?php echo ($idoso['likes'] > 0) ? 'liked' : ''; ?>" data-user-id="<?php echo $idoso['id']; ?>">&#x2764;</button>
        <span class="like-count"><?php echo $idoso['likes']; ?></span>
    </div>

    <div class="profile-header">
        <img src="<?php echo $fotoPerfil; ?>" alt="Foto de <?php echo htmlspecialchars($idoso['nome']); ?>">
        <div class="profile-info">
            <h1><?php echo htmlspecialchars($idoso['nome']); ?></h1>
            <p><strong>Idade:</strong> <?php echo htmlspecialchars($idoso['idade']); ?> anos</p>
            <p><strong>Cidade:</strong> <?php echo htmlspecialchars($idoso['cidade_de_origem']); ?></p>
            <p><strong>Data de Cadastro:</strong> <?php echo date("d/m/Y", strtotime($idoso['criado_em'])); ?></p>
            <p><strong>Bio:</strong> <?php echo htmlspecialchars($idoso['bio']); ?></p>
        </div>
    </div>

    <?php if (!empty($fotosDiarias)): ?>
    <div class="section">
        <h2>Fotos do Dia a Dia</h2>
        <div class="photos">
            <?php foreach ($fotosDiarias as $foto): ?>
                <img src="uploads/fotos/<?php echo htmlspecialchars($foto); ?>" alt="Foto diária">
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($videos)): ?>
    <div class="section">
        <h2>Vídeos do Dia a Dia</h2>
        <div class="videos">
            <?php foreach ($videos as $video): ?>
                <video src="uploads/videos/<?php echo htmlspecialchars($video); ?>" controls></video>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    const heartBtn = document.querySelector('.heart-btn');
    const likeCountSpan = document.querySelector('.like-count');

    heartBtn.addEventListener('click', () => {
        const userId = heartBtn.getAttribute('data-user-id');
        const isLiked = heartBtn.classList.toggle('liked');

        let currentLikes = parseInt(likeCountSpan.textContent);
        if (isLiked) {
            currentLikes++;
        } else {
            currentLikes--;
        }
        likeCountSpan.textContent = currentLikes;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_likes.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('user_id=' + userId + '&action=' + (isLiked ? 'like' : 'unlike'));
    });
</script>

</body>
</html>
