<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?error=Por favor, faça o login primeiro.");
    exit();
}

$conn = new mysqli("localhost", "root", "", "abrigo_sao_francisco_de_assis");
if ($conn->connect_error) die("Conexão falhou: " . $conn->connect_error);

$idoso_id = $_GET['id'] ?? null;
if (!$idoso_id) {
    header("Location: listar_idosos.php?error=ID do idoso não fornecido.");
    exit();
}

// Buscar idoso
$stmt = $conn->prepare("SELECT * FROM idosos WHERE id = ?");
$stmt->bind_param("i", $idoso_id);
$stmt->execute();
$result = $stmt->get_result();
$idoso = $result->fetch_assoc();
if (!$idoso) {
    header("Location: listar_idosos.php?error=Idoso não encontrado.");
    exit();
}

// Atualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome = $_POST['nome'];
    $nova_idade = (int)$_POST['idade'];
    $nova_cidade = $_POST['cidade_de_origem'];
    $nova_bio = $_POST['bio'];

    $semAlteracao = (
        $novo_nome === $idoso['nome'] &&
        $nova_idade === (int)$idoso['idade'] &&
        $nova_cidade === $idoso['cidade_de_origem'] &&
        $nova_bio === $idoso['bio']
    );

    if ($semAlteracao) {
        $_SESSION['error'] = "Nenhuma atualização realizada.";
        header("Location: editar_perfil_idoso.php?id=$idoso_id");
        exit();
    }

    $stmt = $conn->prepare("UPDATE idosos SET nome = ?, idade = ?, cidade_de_origem = ?, bio = ? WHERE id = ?");
    $stmt->bind_param("sissi", $novo_nome, $nova_idade, $nova_cidade, $nova_bio, $idoso_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Perfil atualizado com sucesso.";
    } else {
        $_SESSION['error'] = "Erro ao atualizar perfil.";
    }

    header("Location: editar_perfil_idoso.php?id=$idoso_id");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Perfil do Idoso</title>
</head>
<body>
<main class="main-content">
    <span class="bem-vindo"><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>! Aqui, você pode modificar os dados do idoso.</span>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="mensagem-erro" id="mensagemErro">
        <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        ?>
    </div>
    <?php endif; ?>

    <form action="editar_perfil_idoso.php?id=<?php echo $idoso_id; ?>" method="post">
        <a href="ADMpage.php" class="botao-voltar">&#8592; Voltar</a>
        <hr>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($idoso['nome'] ?? ''); ?>" required>

        <label for="idade">Idade:</label>
        <input type="number" name="idade" id="idade" value="<?php echo htmlspecialchars($idoso['idade'] ?? ''); ?>" required>

        <label for="cidade_de_origem">Cidade de Origem:</label>
        <input type="text" name="cidade_de_origem" id="cidade_de_origem" value="<?php echo htmlspecialchars($idoso['cidade_de_origem'] ?? ''); ?>">

        <label for="bio">Biografia / Observações:</label>
        <textarea name="bio" id="bio" rows="3"><?php echo htmlspecialchars($idoso['bio'] ?? ''); ?></textarea>

        <input type="submit" value="Atualizar Perfil">
    </form>
</main>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const msg = document.getElementById('mensagemErro');
    if (msg) setTimeout(() => msg.remove(), 6000);
  });
</script>
</body>
</html>
