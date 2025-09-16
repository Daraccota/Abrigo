<?php
// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "abrigo_sao_francisco_de_assis");

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se recebeu um ID
$idoso_id = $_GET['id'] ?? null;
if (!$idoso_id) {
    die("ID do idoso não informado.");
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
    $novo_nome   = $_POST['nome'];
    $nova_idade  = (int)$_POST['idade'];
    $nova_cidade = $_POST['cidade_de_origem'];
    $novo_status = $_POST['status'];
    $nova_bio    = $_POST['bio'];


    $semAlteracao = (
        $novo_nome   === $idoso['nome'] &&
        $nova_idade  === (int)$idoso['idade'] &&
        $nova_cidade === $idoso['cidade_de_origem'] &&
        $novo_status === $idoso['status'] &&
        $nova_bio    === $idoso['bio']
    );

    if ($semAlteracao) {
        header("Location: editar_perfil_idoso.php?id=$idoso_id&error=Nenhuma atualização realizada.");
        exit();
    }

    $stmt = $conn->prepare("UPDATE idosos SET nome = ?, idade = ?, cidade_de_origem = ?, bio = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sisssi", $novo_nome, $nova_idade, $nova_cidade, $nova_bio, $novo_status, $idoso_id);


    if ($stmt->execute()) {
        header("Location: editar_perfil_idoso.php?id=$idoso_id&success=Perfil atualizado com sucesso.");
    } else {
        header("Location: editar_perfil_idoso.php?id=$idoso_id&error=Erro ao atualizar perfil.");
    }
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


    <form action="editar_perfil_idoso.php?id=<?php echo $idoso_id; ?>" method="post">
        <a href="ADMpage.php" class="botao-voltar">&#8592; Voltar</a>
        <hr>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($idoso['nome'] ?? ''); ?>" required>

        <label for="idade">Idade:</label>
        <input type="number" name="idade" id="idade" value="<?php echo htmlspecialchars($idoso['idade'] ?? ''); ?>" required>

        <label for="cidade_de_origem">Cidade de Origem:</label>
        <input type="text" name="cidade_de_origem" id="cidade_de_origem" value="<?php echo htmlspecialchars($idoso['cidade_de_origem'] ?? ''); ?>">

        <label for="status">Status</label>
        <select name="status">
            <option value="ativo" <?php echo($idoso['status'] === 'ativo') ? 'selected' : ''; ?>>Ativo</option>
            <option value="revisar" <?php echo($idoso['status'] === 'revisar') ? 'selected' : ''; ?>>Revisar</option>
            <option value="inativo" <?php echo($idoso['status'] === 'inativo') ? 'selected' : ''; ?>>Inativo</option>
        </select>


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
