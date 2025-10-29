<?php
// Função para limpar texto
function limpar_texto($str, $allow_plus = false) {
    if ($allow_plus) {
        // Permite +, dígitos, (, ), -, espaço
        return preg_replace("/[^0-9+() -]/", "", $str);
    } else {
        return preg_replace("/[^0-9]/", "", $str);
    }
}
// Função para validar CPF
function validar_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11) {
        return false;
    }
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}
// Conexão com o banco
$mysqli = new mysqli("localhost", "root", "", "crud_clientes");
if ($mysqli->connect_errno) {
    die("Falha na conexão: " . $mysqli->connect_error);
}
$erro = false;
$mensagem = "";
$sucesso = false; // Novo flag pra modal
// Inicializa variáveis
$nome = '';
$email = '';
$telefone = '';
$nascimento = '';
$cpf = '';
$cep = '';
$senha = '';
$confirmarSenha = '';
$num_casa = '';
$complemento = '';
$endereco = '';
$materno = '';
$genero = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $nascimento = $_POST['nascimento'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $cep = $_POST['cep'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmarSenha'] ?? '';
    $num_casa = $_POST['numerocasa'] ?? '';
    $complemento = $_POST['complemento'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $materno = $_POST['materno'] ?? '';
    $genero = $_POST['genero'] ?? '';
    // Limpa caracteres não numéricos (permitindo formato para telefone)
    $telefone = limpar_texto($telefone, true); // Permite ( ) - 
    $cpf = limpar_texto($cpf);
    $cep = limpar_texto($cep);
    // Validações básicas (mantidas do seu PHP)
    if (empty($nome)) {
        $erro = true;
        $mensagem = "Preencha o nome completo.";
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = true;
        $mensagem = "Preencha um e-mail válido.";
    } elseif (empty($telefone)) {
        $erro = true;
        $mensagem = "Informe um número de telefone.";
    } elseif (!validar_cpf($cpf)) {
        $erro = true;
        $mensagem = "CPF inválido. Digite um CPF existente e válido.";
    } elseif (!empty($nascimento)) {
        $anoNascimento = (int)date('Y', strtotime($nascimento));
        if ($anoNascimento < 1920) {
            $erro = true;
            $mensagem = "Ano de nascimento inválido.";
        } elseif ($anoNascimento > date('Y')) {
            $erro = true;
            $mensagem = "Ano de nascimento não pode ser no futuro.";
        }
    } elseif (strlen($cep) != 8) {
        $erro = true;
        $mensagem = "CEP deve conter 8 dígitos.";
    } elseif (strlen($senha) < 8 || strlen($senha) > 16) {
        $erro = true;
        $mensagem = "A senha deve conter entre 8 e 16 caracteres.";
    } elseif ($senha !== $confirmarSenha) {
        $erro = true;
        $mensagem = "As senhas não coincidem.";
    } elseif (empty($materno)) {
        $erro = true;
        $mensagem = "Preencha o nome materno.";
    } elseif (empty($genero)) {
        $erro = true;
        $mensagem = "Selecione o gênero.";
    } else {
        // Validação de CEP real via ViaCEP
        $url = "https://viacep.com.br/ws/$cep/json/";
        $dadosCep = @file_get_contents($url);
        $cepData = json_decode($dadosCep, true);
        if (!$dadosCep || isset($cepData['erro'])) {
            $erro = true;
            $mensagem = "CEP inválido ou não encontrado.";
        } else {
            $endereco = $cepData['logradouro'] ?? $endereco;
        }
    }
    $dataFormatada = !empty($nascimento) ? date('Y-m-d', strtotime($nascimento)) : null;
    if (!$erro) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO clientes 
            (nome, email, telefone, nascimento, CPF, CEP, Senha, num_casa, complemento, endereco, materno, genero)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssssssssss", 
            $nome, $email, $telefone, $dataFormatada, $cpf, $cep, $senhaHash, 
            $num_casa, $complemento, $endereco, $materno, $genero
        );
        if ($stmt->execute()) {
            $sucesso = true;
            $mensagem = "";
            $nome = $email = $telefone = $nascimento = $cpf = $cep = $senha = $confirmarSenha = $num_casa = $complemento = $endereco = $materno = $genero = '';
        } else {
            $erro = true;
            $mensagem = "Erro ao salvar no banco: " . $mysqli->error; // Mostra erro real
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
    <script>
        function validarFormulario() {
            let valido = true;
            const nome = document.getElementById("nome").value;
            const materno = document.getElementById("materno").value;
            const cpf = document.getElementById("cpf").value;
            const email = document.getElementById("email").value;
            const telefone = document.getElementById("telefone").value;
            const senha = document.getElementById("senha").value;
            const confirmarSenha = document.getElementById("confirmarSenha").value;
            const nascimento = document.getElementById("nascimento").value;
            const cep = document.getElementById("cep").value;
            const endereco = document.getElementById("endereco").value;
            const numerocasa = document.getElementById("numerocasa").value;

            const regexNome = /^[a-zA-Z\s]{15,80}$/; // Manter original
            const regexMaterno = /^[a-zA-Z\s]{15,80}$/; // Manter original
            const regexCPF = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
            const regexEmail = /^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/;
            const regexTelefone = /^\(\+55\)\d{2} \d{9}$/; // Manter original
            const regexSenha = /^[a-zA-Z]{8}$/; // Manter original

            // Limpar erros
            const camposErro = ["nome", "materno", "cpf", "email", "telefone", "senha", "confirmar", "nascimento", "cep", "endereco", "numerocasa"];
            camposErro.forEach(id => document.getElementById(`erro-${id}`).textContent = "");

            // Validações (manter critérios originais)
            if (!regexNome.test(nome)) {
                document.getElementById("erro-nome").textContent = "Seu nome deve ter entre 15 e 80 letras.";
                valido = false;
            }
            if (!regexMaterno.test(materno)) {
                document.getElementById("erro-materno").textContent = "Nome materno deve ter entre 15 a 80 letras.";
                valido = false;
            }
            if (!regexCPF.test(cpf)) {
                document.getElementById("erro-cpf").textContent = "CPF inválido. Ex: 123.456.789-00";
                valido = false;
            }
            if (!regexEmail.test(email)) {
                document.getElementById("erro-email").textContent = "E-mail inválido.";
                valido = false;
            }
            if (!regexTelefone.test(telefone)) {
                document.getElementById("erro-telefone").textContent = "Formato de telefone celular inválido.";
                valido = false;
            }
            if (!nascimento) {
                document.getElementById("erro-nascimento").textContent = "Preencha a data de nascimento.";
                valido = false;
            }
            if (!/^\d{5}-\d{3}$/.test(cep)) {
                document.getElementById("erro-cep").textContent = "CEP deve seguir o formato 00000-000.";
                valido = false;
            }
            // Validação: apenas se os campos estão preenchidos
            if (!endereco.trim()) {
                document.getElementById("erro-endereco").textContent = "Preencha o endereço.";
                valido = false;
            }   
            if (!numerocasa.trim()) {
                document.getElementById("erro-numerocasa").textContent = "Preencha o número da residência.";
                valido = false;

            if (!regexSenha.test(senha)) {
                document.getElementById("erro-senha").textContent = "Senha deve conter exatamente 8 letras.";
                valido = false;
            }
            if (senha !== confirmarSenha) {
                document.getElementById("erro-confirmar").textContent = "As senhas não coincidem.";
                valido = false;
            }
            return valido;
        }
    </script>
</head>
<body>
<!-- Seu header -->
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
       <button id="btn-sair" onclick="sair()">Sair</button>
    </div>
  </nav>
</header>
<main>
    <section class="container">
        <h2>DADOS PESSOAIS</h2>
        <?= $mensagem ?? "" ?> 
        <form method="POST" action="" onsubmit="return validarFormulario();">
            <fieldset>
                <legend>Dados pessoais</legend>
            <label for="nome">NOME COMPLETO</label>
            <input type="text" id="nome" name="nome" class="input" value="<?= htmlspecialchars($nome) ?>" required>
            <span id="erro-nome" class="error"></span>

            <label for="materno">NOME MATERNO</label>
            <input type="text" id="materno" name="materno" class="input" value="<?= htmlspecialchars($materno) ?>" required>
            <span id="erro-materno" class="error"></span>

            <label for="genero">GÊNERO</label>
            <select id="genero" name="genero" class="input" required>
                <option value="">Selecione...</option>
                <option value="Masculino" <?= ($genero == "Masculino") ? 'selected' : '' ?>>Masculino</option>
                <option value="Feminino" <?= ($genero == "Feminino") ? 'selected' : '' ?>>Feminino</option>
                <option value="Outro" <?= ($genero == "Outro") ? 'selected' : '' ?>>Outro</option>
            </select>

            <label for="nascimento">DATA DE NASCIMENTO</label>
            <input type="date" id="nascimento" name="nascimento" class="input" 
                   min="1920-01-01" max="<?= date('Y-m-d') ?>"
                   value="<?= htmlspecialchars($nascimento) ?>">
            <span id="erro-nascimento" class="error"></span>

            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" class="input" placeholder="000.000.000-00" value="<?= htmlspecialchars($cpf) ?>" required>
            <span id="erro-cpf" class="error"></span>
            </fieldset>
            <fieldset>
            <legend>Contato</legend>
            <label for="email">E-MAIL</label>
            <input type="email" id="email" name="email" class="input" value="<?= htmlspecialchars($email) ?>" required>
            <span id="erro-email" class="error"></span>

            <label for="telefone">TELEFONE CELULAR</label>
            <input type="text" id="telefone" name="telefone" class="input" placeholder="(11) 98888-8888" value="<?= htmlspecialchars($telefone) ?>" required>
            <span id="erro-telefone" class="error"></span>
            </fieldset>
            <fieldset>
                <legend>Endereço</legend>
            <label for="cep">CEP</label>
            <input type="text" id="cep" name="cep" class="input" placeholder="00000-000" value="<?= htmlspecialchars($cep) ?>" required>
            <span id="erro-cep" class="error"></span>

            <label for="endereco">ENDEREÇO</label>
            <input type="text" id="endereco" name="endereco" class="input" value="<?= htmlspecialchars($endereco) ?>">
            <span id="erro-endereco" class="error"></span>

            <label for="numerocasa">NÚMERO</label>
            <input type="text" id="numerocasa" name="numerocasa" class="input" value="<?= htmlspecialchars($num_casa) ?>">
            <span id="erro-numerocasa" class="error"></span>

            <label for="complemento">COMPLEMENTO</label>
            <input type="text" id="complemento" name="complemento" class="input" value="<?= htmlspecialchars($complemento) ?>">
            </fieldset>
            <fieldset>
                <legend>Acesso ao sistema</legend>
            <label for="senha">SENHA</label>
            <input type="password" id="senha" name="senha" class="input" required>
            <span id="erro-senha" class="error"></span>

            <label for="confirmarSenha">CONFIRMAR SENHA</label>
            <input type="password" id="confirmarSenha" name="confirmarSenha" class="input" required>
            <span id="erro-confirmar" class="error"></span>
            </fieldset>
            <button type="submit" class="btn">CADASTRAR</button>
            <button type="reset" class="btn">LIMPAR TELA</button>
        </form>
    </section>
</main>
<!-- Modal de Sucesso -->
<div id="modal-sucesso" class="modal" style="display: none;">
    <div class="modal-conteudo">
        <span class="fechar" id="fechar-modal">&times;</span>
        <p>✅ Cadastro realizado com sucesso!</p>
    </div>
</div>
<script>
// === VIA CEP ===
document.getElementById("cep").addEventListener("blur", async function() {
    let cep = this.value.replace(/\D/g, '');
    if (cep.length !== 8) return;
    try {
        const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const dados = await res.json();
        if (dados.erro) return alert("CEP não encontrado!");
        document.getElementById("endereco").value = dados.logradouro || "";
    } catch (e) {
        alert("Erro ao buscar CEP.");
    }
});

// === MODAL + REDIRECIONAMENTO ===
<?php if ($sucesso): ?>
    (function() {
        const modal = document.getElementById("modal-sucesso");
        modal.style.display = "flex"; // Ativa o flex pra centralizar

        const irParaLogin = () => {
            window.location.href = "Login.php";
        };

        document.getElementById("fechar-modal").onclick = irParaLogin;
        modal.onclick = (e) => {
            if (e.target === modal) irParaLogin();
        };

        setTimeout(irParaLogin, 3000); // Redireciona em 3 segundos
    })();
<?php endif; ?>
</script>
</body>
</html>