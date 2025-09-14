<?php
// Configurações do banco de dados
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Busca todos os moradores cadastrados, incluindo a coluna de likes
$sql = "SELECT id, nome, idade, cidade_de_origem, foto_perfil, criado_em, likes FROM idosos ORDER BY criado_em DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moradores do Abrigo</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
    display: flex;
}

/* Menu lateral */
.sidebar {
    width: 220px;
    height: 100vh;
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.2);
    position: fixed;
    top: 0;
    left: 0;
}
.sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
    border-bottom: 2px solid #34495e;
    padding-bottom: 10px;
}
.sidebar ul {
    list-style: none;
    padding: 0;
}
.sidebar ul li {
    margin-bottom: 15px;
}
.sidebar ul li a {
    color: #ecf0f1;
    text-decoration: none;
    display: block;
    padding: 10px;
    border-radius: 5px;
    transition: 0.3s;
}
.sidebar ul li a:hover {
    background-color: #34495e;
}

/* Conteúdo principal */
.main-content {
    margin-left: 240px;
    padding: 20px;
    flex-grow: 1;
}
.main-content h1 {
    text-align: center;
    margin-bottom: 30px;
    color: #2c3e50;
}

/* Cards de moradores */
.card-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

.card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    position: relative;
    transition: transform 0.2s, box-shadow 0.2s;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}
.profile-pic {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid #ddd;
}
.info {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.info h3 {
    margin: 0;
    color: #2c3e50;
}
.info p {
    margin: 0;
    font-size: 0.9em;
    color: #555;
}
.card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

/* Like */
.like-container {
    display: flex;
    align-items: center;
    position: absolute;
    top: 10px;
    right: 10px;
}
.heart-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 24px;
    color: #ccc;
    transition: color 0.2s ease;
}
.heart-btn.liked {
    color: #e74c3c;
}
.like-count {
    margin-left: 5px;
    font-weight: bold;
    color: #555;
}
</style>
</head>
<body>

<div class="sidebar">
    <h2>Abrigo São Francisco</h2>
    <ul>
        <li><a href="ADMpage.php">Cadastro de Morador</a></li>
        <li><a href="moradores_do_abrigo.php">Moradores</a></li>
        <li><a href="#">Quem Somos</a></li>
        <li><a href="#">Doações</a></li>
        <li><a href="#">Formações</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Moradores Cadastrados</h1>
    <div class="card-container">
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $foto = !empty($row['foto_perfil']) 
                    ? "uploads/perfil/" . htmlspecialchars($row['foto_perfil']) 
                    : "https://via.placeholder.com/100";
        ?>
        <div style="position: relative;">
            <a href="perfil_idoso.php?id=<?php echo $row['id']; ?>" class="card-link">
                <div class="card">
                    <img src="<?php echo $foto; ?>" alt="Foto de <?php echo htmlspecialchars($row['nome']); ?>" class="profile-pic">
                    <div class="info">
                        <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
                        <p><strong>Idade:</strong> <?php echo htmlspecialchars($row['idade']); ?> anos</p>
                        <p><strong>Cidade:</strong> <?php echo htmlspecialchars($row['cidade_de_origem']); ?></p>
                        <p><strong>Data de Cadastro:</strong> <?php echo date("d/m/Y", strtotime($row['criado_em'])); ?></p>
                    </div>
                </div>
            </a>
            <div class="like-container">
                <button class="heart-btn" data-user-id="<?php echo $row['id']; ?>">&#x2764;</button>
                <span class="like-count"><?php echo $row['likes']; ?></span>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<p>Nenhum morador cadastrado ainda.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>

<script>
const heartButtons = document.querySelectorAll('.heart-btn');
heartButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        event.stopPropagation();
        const userId = button.getAttribute('data-user-id');
        const likeCountSpan = button.nextElementSibling;
        const isLiked = button.classList.toggle('liked');

        let currentLikes = parseInt(likeCountSpan.textContent);
        if (isLiked) currentLikes++;
        else currentLikes--;
        likeCountSpan.textContent = currentLikes;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_likes.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('user_id=' + userId + '&action=' + (isLiked ? 'like' : 'unlike'));
    });
});
</script>

</body>
</html>
