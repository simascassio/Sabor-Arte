<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . '/conexao.php');

// --- IMPEDIR ACESSO SEM LOGIN ---
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Você precisa estar logado para acessar esta página.'); window.location.href='Login.php';</script>";
    exit;
}

$id = intval($_SESSION['id']); // <-- ESSENCIAL: PEGA O USUÁRIO LOGADO

// --- BUSCA DADOS DO USUÁRIO ---
$sql = "SELECT * FROM clientes WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$query = $stmt->get_result();

if ($query->num_rows == 0) {
    die("Erro: Usuário não encontrado.");
}

$cliente = $query->fetch_assoc();

$mensagem = "";
$sucesso = false; // <-- ADICIONADO (OBRIGATÓRIO)

// --- QUANDO O USUÁRIO SALVA OS DADOS ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome        = trim($_POST['nome'] ?? '');
    $materno     = trim($_POST['materno'] ?? '');
    $genero      = trim($_POST['genero'] ?? '');
    $nascimento  = trim($_POST['nascimento'] ?? '');
    $cpf         = trim($_POST['cpf'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $telefone    = trim($_POST['telefone'] ?? '');
    $telefonefixo= trim($_POST['telefonefixo'] ?? '');
    $cep         = trim($_POST['cep'] ?? '');
    $endereco    = trim($_POST['endereco'] ?? '');
    $num_casa    = trim($_POST['numerocasa'] ?? '');
    $complemento = trim($_POST['complemento'] ?? '');
    $login       = trim($_POST['login'] ?? '');
    $senha       = $_POST['senha'] ?? '';
    $confirmar   = $_POST['confirmarSenha'] ?? '';

    // --- VALIDAÇÃO DA SENHA ---
    if (!empty($senha)) {

        if ($senha !== $confirmar) {
            $mensagem = "As senhas não coincidem.";
        } 
        elseif (strlen($senha) !== 8) {
            $mensagem = "A senha deve ter exatamente 8 caracteres.";
        }
        elseif (preg_match('/[0-9]/', $senha)) {
            $mensagem = "A senha não pode conter números.";
        }
        else {
            $senhaFinal = password_hash($senha, PASSWORD_DEFAULT);
        }

    } else {
        $senhaFinal = $cliente['Senha']; // mantém a senha antiga
    }

    // --- SE NÃO TEM ERRO, ATUALIZA ---
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
            $sucesso = true;   // <-- MODAL VAI ATIVAR
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
<link rel="stylesheet" href="css/editar-usuario.css">
<script src="js/dark.js" defer></script>
 <script src="js/navbar.js" defer></script>
</head>
<body>

 <header class="opcoes">
  <nav class="container-navbar">

    <div class="nav-esquerda">
      <a href="Home.php" class="text">Home</a>
      <a href="Home.php#redes" class="text">Contato</a>
      <a href="finalizar.php" class="text">Pedido</a>

      <div class="dropdown">
        <a href="Cardapio.php" class="text">Cardápio</a>
        <div class="dropdown-content">
          <a href="Cardapio.php">Pizzas</a>
          <a href="Cardapio.php#sobremesas">Sobremesas</a>
          <a href="Cardapio.php#bebidas">Bebidas</a>
        </div>
      </div>
    </div>

    <div class="usuario-box">
      <?php if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])): ?>
        
        <!-- Nome -->
        <span id="nome-usuario" class="text">
          <?= htmlspecialchars($_SESSION['usuario']) ?>
        </span>

        <!-- Ícone -->
        <img 
          id="usuario-icone" 
          src="https://img.icons8.com/ios-filled/50/FFFFFF/user-male-circle.png"
          alt="Usuário"
          onclick="toggleMenu()"
        >

        <!-- Menu do usuário -->
        <div class="submenu-usuario" id="submenu-usuario">
          <a href="editar.php">Editar perfil</a>
          <a href="meus-pedidos.php">Meus pedidos</a>
          <a href="logout.php">Sair</a>
        </div>

      <?php else: ?>
        <a href="Login.php" class="text">Login</a>
      <?php endif; ?>
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

<label>NOVA SENHA (opcional)</label>
<input type="password" name="senha" class="input">

<label>CONFIRMAR NOVA SENHA</label>
<input type="password" name="confirmarSenha" class="input">
</fieldset>

<button type="submit" class="btn">SALVAR ALTERAÇÕES</button>
<a href="home.php" class="btn">VOLTAR</a>

</form>
<img id="dark-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077517.png" alt="Ativar tema escuro">
<img id="light-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077095.png" alt="Ativar tema claro" style="display:none;">


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

    const irParaHome = () => window.location.href = "home.php";

    document.getElementById("fechar-modal").onclick = irParaHome;

    modal.onclick = (e) => { 
        if (e.target === modal) irParaHome(); 
    };

    setTimeout(irParaHome, 3000);

})();
<?php endif; ?>
</script>

</body>
</html>
