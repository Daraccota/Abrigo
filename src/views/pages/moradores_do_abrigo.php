<?php
// Conexão com o banco
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Conexão falhou: " . $conn->connect_error);

$sql = "SELECT id, nome, idade, cidade_de_origem, foto_perfil, criado_em, likes FROM idosos ORDER BY criado_em DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Painel de Moradores</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
  background: radial-gradient(circle at top left, #b3b3b2ff, #504f4eff);
  color: #fff;
  font-family: "Poppins", sans-serif;
  min-height: 100vh;
}

/* HEADER */
.navbar {
  backdrop-filter: blur(10px);
  background: linear-gradient(135deg, #656263ff, #242e35ff);
  border-bottom: 1px solid rgba(255,255,255,0.05);
}
.navbar-brand {
  font-weight: 600;
  color: #00f0ea !important;
}
.navbar-brand i {
  color: #00f0ea;
}
.offcanvas {
  background: #141225;
  color: #ddd;
}
.offcanvas a {
  color: #ccc;
  text-decoration: none;
  display: block;
  padding: .7rem 1rem;
  border-radius: .5rem;
  transition: .3s;
}
.offcanvas a:hover {
  background: rgba(255,255,255,0.05);
  color: #fff;
}

/* MAIN CONTENT */
main {
  margin-top: 6rem;
  padding: 2rem 1rem;
}

/* CARDS */
.card {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 15px;
  color: #fff;
  transition: all .3s ease;
  overflow: hidden;
  cursor: pointer; /* <- NOVO: indica que o card é clicável */
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.5);
}
.card img {
  border-radius: 12px;
  border: 2px solid #00f0ea;
  object-fit: cover;
  height: 120px;
  width: 120px;
}
.card-title {
  font-size: 1.2rem;
  margin-bottom: .5rem;
}
.card-text {
  font-size: .95rem;
  color: #ccc;
}

/* LIKE BUTTON */
.like-btn {
  border: none;
  background: none;
  color: #ccc;
  font-size: 1.3rem;
  transition: .3s;
}
.like-btn.liked {
  color: #e74c3c;
  transform: scale(1.2);
}
.like-count {
  margin-left: 6px;
  color: #fff;
  font-weight: 500;
}

/* SECTION TITLE */
h1 {
  text-align: center;
  margin-bottom: 2rem;
  font-weight: 600;
  color: #00f0ea;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
      <i class="bi bi-house-heart"></i> Abrigo São Francisco
    </a>

    <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
      <i class="bi bi-list fs-2"></i>
    </button>

    <div class="collapse navbar-collapse justify-content-end d-none d-lg-flex">
      <ul class="navbar-nav gap-3">
        <li><a class="nav-link text-white" href="ADMpage.php"><i class="bi bi-person-plus"></i> Cadastro</a></li>
        <li><a class="nav-link text-white" href="moradores_do_abrigo.php"><i class="bi bi-people"></i> Moradores</a></li>
        <li><a class="nav-link text-white" href="#"><i class="bi bi-info-circle"></i> Quem Somos</a></li>
        <li><a class="nav-link text-white" href="#"><i class="bi bi-hand-heart"></i> Doações</a></li>
        <li><a class="nav-link text-white" href="#"><i class="bi bi-journal-text"></i> Formações</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- MENU LATERAL -->
<div class="offcanvas offcanvas-end" id="menuLateral" tabindex="-1">
  <div class="offcanvas-header">
    <h5><i class="bi bi-house-heart"></i> Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <a href="ADMpage.php"><i class="bi bi-person-plus"></i> Cadastro</a>
    <a href="moradores_do_abrigo.php"><i class="bi bi-people"></i> Moradores</a>
    <a href="#"><i class="bi bi-info-circle"></i> Quem Somos</a>
    <a href="#"><i class="bi bi-hand-heart"></i> Doações</a>
    <a href="#"><i class="bi bi-journal-text"></i> Formações</a>
    <hr class="border-secondary">
    <a href="#"><i class="bi bi-gear"></i> Configurações</a>
    <div class="mt-auto pt-4 text-secondary small">Versão do sistema • 1.0</div>
  </div>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<main class="container">
  <h1><i class="bi bi-person-bounding-box"></i> Moradores Cadastrados</h1>
  <div class="row g-4">
    <?php
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $foto = !empty($row['foto_perfil'])
                ? "uploads/perfil/" . htmlspecialchars($row['foto_perfil'])
                : "https://via.placeholder.com/120";
    ?>
    <div class="col-md-6 col-lg-4">
      <div class="card p-3 h-100 card-clickable" data-id="<?php echo $row['id']; ?>">
        <div class="d-flex align-items-center gap-3">
          <img src="<?php echo $foto; ?>" alt="Foto de <?php echo htmlspecialchars($row['nome']); ?>">
          <div>
            <h5 class="card-title"><?php echo htmlspecialchars($row['nome']); ?></h5>
            <p class="card-text mb-1"><i class="bi bi-cake"></i> <?php echo htmlspecialchars($row['idade']); ?> anos</p>
            <p class="card-text mb-1"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['cidade_de_origem']); ?></p>
            <p class="card-text"><i class="bi bi-calendar3"></i> <?php echo date("d/m/Y", strtotime($row['criado_em'])); ?></p>
          </div>
        </div>
        <div class="d-flex justify-content-end align-items-center mt-3">
          <button class="like-btn" data-user-id="<?php echo $row['id']; ?>">
            <i class="bi bi-heart-fill"></i>
          </button>
          <span class="like-count"><?php echo $row['likes']; ?></span>
        </div>
      </div>
    </div>
    <?php
        }
    } else {
        echo "<p class='text-center text-secondary'>Nenhum morador cadastrado ainda.</p>";
    }
    $conn->close();
    ?>
  </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Redirecionar para o perfil ao clicar no card
document.querySelectorAll('.card-clickable').forEach(card => {
  card.addEventListener('click', () => {
    const id = card.getAttribute('data-id');
    window.location.href = 'perfil_idoso.php?id=' + encodeURIComponent(id);
  });
});

// Botão de like (já existente)
document.querySelectorAll('.like-btn').forEach(button => {
  button.addEventListener('click', (ev) => {
    ev.stopPropagation(); // impede que o clique no botão dispare o redirecionamento
    const id = button.getAttribute('data-user-id');
    const span = button.nextElementSibling;
    const liked = button.classList.toggle('liked');
    let count = parseInt(span.textContent) || 0;
    span.textContent = liked ? count + 1 : Math.max(0, count - 1);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_likes.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('user_id=' + encodeURIComponent(id) + '&action=' + (liked ? 'like' : 'unlike'));
  });
});
</script>
</body>
</html>
