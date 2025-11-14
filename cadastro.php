<?php
include('conexao.php');

// === Funções auxiliares ===
function limpar_texto($str, $allow_plus = false) {
    if ($allow_plus) {
        return preg_replace("/[^0-9+() -]/", "", $str);
    } else {
        return preg_replace("/[^0-9]/", "", $str);
    }
}

function validar_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11) return false;
    if (preg_match('/(\d)\1{10}/', $cpf)) return false;

    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false;
    }
    return true;
}

// === Conexão ===
$mysqli = new mysqli("localhost", "root", "", "crud_clientes");
if ($mysqli->connect_errno) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

// === Variáveis iniciais ===
$erro = false;
$sucesso = false;
$mensagem = "";

$nome = $email = $telefone = $telefonefixo = $nascimento = "";
$cpf = $cep = $senha = $confirmarSenha = "";
$num_casa = $complemento = $endereco = $materno = $genero = $login = "";

// === Processamento do formulário ===
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // --- Coleta e limpeza ---
    $nome           = $_POST['nome'] ?? '';
    $materno        = $_POST['materno'] ?? '';
    $genero         = $_POST['genero'] ?? '';
    $nascimento     = $_POST['nascimento'] ?? '';
    $cpf            = $_POST['cpf'] ?? '';
    $email          = $_POST['email'] ?? '';
    $telefone       = $_POST['telefone'] ?? '';
    $telefonefixo   = $_POST['telefonefixo'] ?? '';
    $cep            = $_POST['cep'] ?? '';
    $endereco       = $_POST['endereco'] ?? '';
    $num_casa       = $_POST['numerocasa'] ?? '';
    $complemento    = $_POST['complemento'] ?? '';
    $login          = $_POST['login'] ?? '';
    $senha          = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmarSenha'] ?? '';

    $telefone       = limpar_texto($telefone, true);
    $telefonefixo   = limpar_texto($telefonefixo, true);
    $cpf            = limpar_texto($cpf);
    $cep            = limpar_texto($cep);

    // --- Validações ---
    if (empty($nome) || strlen($nome) < 7 || strlen($nome) > 61) {
        $erro = true;
        $mensagem = "Preencha o nome completo.";
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = true;
        $mensagem = "Preencha um e-mail válido.";
    } elseif (empty($telefone)) {
        $erro = true;
        $mensagem = "Informe um número de telefone celular.";
    } elseif (!validar_cpf($cpf)) {
        $erro = true;
        $mensagem = "CPF inválido. Digite um CPF válido.";
    } elseif (empty($login) || strlen($login) !== 6) {
        $erro = true;
        $mensagem = "O login deve ter 6 caracteres.";
    } elseif (!empty($nascimento)) {
        $anoNascimento = (int)date('Y', strtotime($nascimento));
        if ($anoNascimento < 1920 || $anoNascimento > date('Y')) {
            $erro = true;
            $mensagem = "Ano de nascimento inválido.";
        }
    } elseif (strlen($cep) != 8) {
        $erro = true;
        $mensagem = "CEP deve conter 8 dígitos.";
    } elseif (empty($materno)) {
        $erro = true;
        $mensagem = "Preencha o nome materno.";
    } elseif (empty($genero)) {
        $erro = true;
        $mensagem = "Selecione o gênero.";
    }

    // --- Senha ---
    // --- Senha ---
if (!$erro) {
    if (strlen($senha) < 8 || strlen($senha) > 8) {
        $erro = true;
        $mensagem = "A senha deve conter exatamente 8 caracteres.";
    } elseif (preg_match('/[0-9]/', $senha)) {
        $erro = true;
        $mensagem = "A senha não pode conter números.";
    } elseif ($senha !== $confirmarSenha) {
        $erro = true;
        $mensagem = "As senhas não coincidem.";
    }
}


    // --- Verifica login duplicado ---
    if (!$erro) {
        $check = $mysqli->prepare("SELECT id FROM clientes WHERE login = ?");
        $check->bind_param("s", $login);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $erro = true;
            $mensagem = "Login já existe. Escolha outro.";
        }
        $check->close();
    }

    // --- Inserção ---
    if (!$erro) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $dataFormatada = !empty($nascimento) ? date('Y-m-d', strtotime($nascimento)) : null;

        $sql = "INSERT INTO clientes 
        (nome, email, telefone, telefonefixo, nascimento, CPF, CEP, Senha, num_casa, complemento, endereco, materno, genero, login)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param(
            "ssssssssssssss",
            $nome, $email, $telefone, $telefonefixo, $dataFormatada,
            $cpf, $cep, $senhaHash, $num_casa, $complemento,
            $endereco, $materno, $genero, $login
        );

        if ($stmt->execute()) {
            $sucesso = true;
            $mensagem = "";
            $nome = $email = $telefone = $telefonefixo = $nascimento = $cpf = $cep = $senha = $confirmarSenha =
            $num_casa = $complemento = $endereco = $materno = $genero = $login = '';
        } else {
            $erro = true;
            $mensagem = "Erro ao salvar no banco: " . $mysqli->error;
        }
        $stmt->close();
    }

    if ($erro && $mensagem) {
        $mensagem = "<p style='color:red;'><b>ERRO: $mensagem</b></p>";
   }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="./css/cadastro.css">
    <script src="js/dark.js" defer></script>
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
                    <a href="Cardapio.php#bebidas">Sobremesas</a>
                    <a href="Cardapio.php#sobremesas">Bebidas</a>
                </div>
            </div>
        </div>

        <div class="usuario-box" onclick="alternarSair()">
            <a href="Login.php" class="text">Login</a>
            <span id="nome-usuario"></span>
            <img id="usuario" src="https://img.icons8.com/ios-filled/50/FFFFFF/user-male-circle.png" alt="Usuário">
      
        </div>
    </nav>
</header>

<main>
    <section class="container">
        <h2>DADOS PESSOAIS</h2>
        <?= $mensagem ?? "" ?>

        <form method="POST" action="">
            <fieldset>
                <legend>Dados pessoais</legend>
                <label for="nome">NOME COMPLETO</label>
                <input type="text" id="nome" name="nome" class="input" value="<?= htmlspecialchars($nome) ?>" required>

                <label for="materno">NOME MATERNO</label>
                <input type="text" id="materno" name="materno" class="input" value="<?= htmlspecialchars($materno) ?>" required>

                <label for="genero">GÊNERO</label>
                <select id="genero" name="genero" class="input" required>
                    <option value="">Selecione...</option>
                    <option value="Masculino" <?= ($genero == "Masculino") ? 'selected' : '' ?>>Masculino</option>
                    <option value="Feminino" <?= ($genero == "Feminino") ? 'selected' : '' ?>>Feminino</option>
                    <option value="Outro" <?= ($genero == "Outro") ? 'selected' : '' ?>>Outro</option>
                </select>

                <label for="nascimento">DATA DE NASCIMENTO</label>
                <input type="date" id="nascimento" name="nascimento" class="input" min="1920-01-01" max="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($nascimento) ?>">

                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" class="input" placeholder="000.000.000-00" value="<?= htmlspecialchars($cpf) ?>" required>
            </fieldset>

            <fieldset>
                <legend>Contato</legend>
                <label for="email">E-MAIL</label>
                <input type="email" id="email" name="email" class="input" value="<?= htmlspecialchars($email) ?>" required>

                <label for="telefone">TELEFONE CELULAR</label>
                <input type="text" id="telefone" name="telefone" class="input" placeholder="(11) 98888-8888" value="<?= htmlspecialchars($telefone) ?>" required>

                <label for="telefonefixo">TELEFONE FIXO</label>
                <input type="text" id="telefonefixo" name="telefonefixo" class="input" placeholder="(21) 2222-2222" value="<?= htmlspecialchars($telefonefixo) ?>">
            </fieldset>

            <fieldset>
                <legend>Endereço</legend>
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" class="input" placeholder="00000-000" value="<?= htmlspecialchars($cep) ?>" required>

                <label for="endereco">ENDEREÇO</label>
                <input type="text" id="endereco" name="endereco" class="input" value="<?= htmlspecialchars($endereco) ?>">

                <label for="numerocasa">NÚMERO</label>
                <input type="text" id="numerocasa" name="numerocasa" class="input" value="<?= htmlspecialchars($num_casa) ?>">

                <label for="complemento">COMPLEMENTO</label>
                <input type="text" id="complemento" name="complemento" class="input" value="<?= htmlspecialchars($complemento) ?>">
            </fieldset>

            <fieldset>
                <legend>Acesso ao sistema</legend>
                <label for="login">LOGIN</label>
                <input type="text" id="login" name="login" class="input" value="<?= htmlspecialchars($login) ?>" required>

                <label for="senha">SENHA</label>
                <input type="password" id="senha" name="senha" class="input" required>

                <label for="confirmarSenha">CONFIRMAR SENHA</label>
                <input type="password" id="confirmarSenha" name="confirmarSenha" class="input" required>
            </fieldset>

            <button type="submit" class="btn">CADASTRAR</button>
            <button type="reset" class="btn">LIMPAR TELA</button>
        </form>
    </section>
</main>

<!-- === MODAL DE SUCESSO === -->
<div id="modal-sucesso" class="modal" style="display: none;">
    <div class="modal-conteudo">
        <span class="fechar" id="fechar-modal">&times;</span>
        <p>✅ Cadastro realizado com sucesso!</p>
    </div>
</div>

<script>
// === MODAL + REDIRECIONAMENTO ===
<?php if ($sucesso): ?>
(function() {
    const modal = document.getElementById("modal-sucesso");
    modal.style.display = "flex";
    const irParaLogin = () => window.location.href = "Login.php";
    document.getElementById("fechar-modal").onclick = irParaLogin;
    modal.onclick = (e) => { if (e.target === modal) irParaLogin(); };
    setTimeout(irParaLogin, 3000);
})();
<?php endif; ?>

// === BUSCA CEP (ViaCEP API) ===
document.getElementById('cep').addEventListener('blur', async function () {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length !== 8) {
        alert('CEP inválido. Deve conter 8 dígitos.');
        return;
    }

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`, { mode: 'cors' });
        if (!response.ok) throw new Error('Erro ao consultar ViaCEP.');

        const data = await response.json();
        if (data.erro) {
            alert('CEP não encontrado.');
            return;
        }

        document.getElementById('endereco').value = data.logradouro || '';
    } catch (e) {
        console.error(e);
        alert('Erro ao buscar CEP. Verifique sua conexão.');
    }
});
</script>

</body>
</html>
