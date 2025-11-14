<?php
include(__DIR__ . '/../conexao.php');

// --- VERIFICA ID ---
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido ou não informado. <a href='usuario.php'>Voltar</a>");
}
$id = intval($_GET['id']);

// --- BUSCA CLIENTE ---
$sql_cliente = "SELECT * FROM clientes WHERE id = ?";
$stmt = $mysqli->prepare($sql_cliente);
$stmt->bind_param("i", $id);
$stmt->execute();
$query_cliente = $stmt->get_result();

if ($query_cliente->num_rows == 0) {
    die("Cliente não encontrado. <a href='usuario.php'>Voltar</a>");
}

$cliente = $query_cliente->fetch_assoc();

$mensagem = "";
$sucesso = false; // <-- AGORA A VARIÁVEL EXISTE SEMPRE

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $materno = trim($_POST['materno'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $nascimento = trim($_POST['nascimento'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $telefonefixo = trim($_POST['telefonefixo'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $num_casa = trim($_POST['numerocasa'] ?? '');
    $complemento = trim($_POST['complemento'] ?? '');
    $login = trim($_POST['login'] ?? '');

    // Como o formulário NÃO tem senha, mantemos a existente
    $senhaFinal = $cliente['Senha'];

    if (empty($mensagem)) {
        $sql = "UPDATE clientes SET 
            nome=?, email=?, telefone=?, telefonefixo=?, nascimento=?, CPF=?, CEP=?, 
            Senha=?, num_casa=?, complemento=?, endereco=?, materno=?, genero=?, login=?
            WHERE id=?";

        $stmt = $mysqli->prepare($sql);

        $stmt->bind_param(
            "ssssssssssssssi",
            $nome, $email, $telefone, $telefonefixo, $nascimento, $cpf, $cep,
            $senhaFinal, $num_casa, $complemento, $endereco, $materno, $genero, $login, $id
        );

        if ($stmt->execute()) {
            $sucesso = true;  
        } else {
            $mensagem = "Erro ao atualizar: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Cliente</title>
<link rel="stylesheet" href="../adm/css/editar.css">
<script src="../js/dark.js" defer></script>
</head>
<body>

<header class="opcoes">
    <nav class="container-navbar">
        <div class="nav-esquerda">
            <a href="" class="text">Home</a>
            <a href="usuario.php" class="text">Usuários</a>
            <a href="" class="text">Log</a>
            <a href="Cardapio.php" class="text">Vendas</a>
        </div>
        <div class="usuario-box" onclick="alternarSair()">
            <span id="nome-usuario"></span>
            <img id="usuario" src="https://img.icons8.com/ios-filled/50/FFFFFF/user-male-circle.png" alt="Usuário">
   
        </div>
    </nav>
</header>

<main>
<section class="container">
<h2>Editar Dados do Cliente</h2>

<?= $mensagem ? "<p style='color:red;'>$mensagem</p>" : "" ?>

<form method="POST">

<fieldset>
<legend>Dados pessoais</legend>

<label>NOME COMPLETO</label>
<input type="text" name="nome" class="input" value="<?= htmlspecialchars($cliente['nome']) ?>" required>

<label>NOME MATERNO</label>
<input type="text" name="materno" class="input" value="<?= htmlspecialchars($cliente['materno']) ?>" required>

<label>GÊNERO</label>
<select name="genero" class="input" required>
  <option value="">Selecione...</option>
  <option value="Masculino" <?= ($cliente['genero'] == "Masculino") ? "selected" : "" ?>>Masculino</option>
  <option value="Feminino" <?= ($cliente['genero'] == "Feminino") ? "selected" : "" ?>>Feminino</option>
  <option value="Outro" <?= ($cliente['genero'] == "Outro") ? "selected" : "" ?>>Outro</option>
</select>

<label>DATA DE NASCIMENTO</label>
<input type="date" name="nascimento" class="input" value="<?= htmlspecialchars($cliente['nascimento']) ?>">

<label>CPF</label>
<input type="text" name="cpf" class="input" value="<?= htmlspecialchars($cliente['CPF']) ?>" required>
</fieldset>

<fieldset>
<legend>Contato</legend>
<label>E-MAIL</label>
<input type="email" name="email" class="input" value="<?= htmlspecialchars($cliente['email']) ?>" required>

<label>TELEFONE CELULAR</label>
<input type="text" name="telefone" class="input" value="<?= htmlspecialchars($cliente['telefone']) ?>" required>

<label>TELEFONE FIXO</label>
<input type="text" name="telefonefixo" class="input" value="<?= htmlspecialchars($cliente['telefonefixo']) ?>">
</fieldset>

<fieldset>
<legend>Endereço</legend>
<label>CEP</label>
<input type="text" name="cep" class="input" value="<?= htmlspecialchars($cliente['CEP']) ?>" required>

<label>ENDEREÇO</label>
<input type="text" name="endereco" class="input" value="<?= htmlspecialchars($cliente['endereco']) ?>">

<label>NÚMERO</label>
<input type="text" name="numerocasa" class="input" value="<?= htmlspecialchars($cliente['num_casa']) ?>">

<label>COMPLEMENTO</label>
<input type="text" name="complemento" class="input" value="<?= htmlspecialchars($cliente['complemento']) ?>">
</fieldset>

<fieldset>
<legend>Acesso ao sistema</legend>
<label>LOGIN</label>
<input type="text" name="login" class="input" value="<?= htmlspecialchars($cliente['login']) ?>" required>
</fieldset>

<button type="submit" class="btn">SALVAR ALTERAÇÕES</button>
<a href="usuario.php" class="btn">VOLTAR</a>

</form>

<!-- Botões de modo escuro -->
<img id="dark-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077517.png" alt="Ativar tema escuro">
<img id="light-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077095.png" alt="Ativar tema claro" style="display:none;">

</section>

<!-- MODAL -->
<div id="modal-sucesso" class="modal" style="display: none;">
    <div class="modal-conteudo">
        <span class="fechar" id="fechar-modal">&times;</span>
        <p>✅ Cadastro editado com sucesso!</p>
    </div>
</div>

</main>

<script>
<?php if ($sucesso): ?>
(function() {
    const modal = document.getElementById("modal-sucesso");
    modal.style.display = "flex";

    const irParaUsuarios = () => window.location.href = "usuario.php";

    document.getElementById("fechar-modal").onclick = irParaUsuarios;

    modal.onclick = (e) => { 
        if (e.target === modal) irParaUsuarios(); 
    };

    setTimeout(irParaUsuarios, 3000);
})();
<?php endif; ?>
</script>

</body>
</html>
