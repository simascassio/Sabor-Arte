<?php
session_start();
include(__DIR__ . '/../conexao.php');




// == conta usuarios cadastrados
$sql_count = "SELECT COUNT(*) AS total FROM clientes";
$result_count = $mysqli->query($sql_count) or die("Erro na contagem de usuários: " . $mysqli->error);
$row_count = $result_count->fetch_assoc();
$total_usuarios = $row_count['total'] ?? 0;

// == conta os acessos 
$sql_acessos = "
    SELECT COUNT(DISTINCT usuario) AS total_acessos 
    FROM acessos 
    WHERE LOWER(usuario) != 'admin'
";
$result_acessos = $mysqli->query($sql_acessos) or die("Erro na contagem de acessos: " . $mysqli->error);
$row_acessos = $result_acessos->fetch_assoc();
$total_acessos = $row_acessos['total_acessos'] ?? 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel do Administrador - Sabor & Arte</title>
  <link rel="stylesheet" href="css/adm.css">
  <script src="js/dark.js" defer></script>
  <script src="js/login.js" defer></script> 
</head>
<body>
  <header class="opcoes">
    <nav class="container-navbar">
      <div class="nav-esquerda">
        <a href="home-adm.php" class="text">Home</a>
        <a href="usuario.php" class="text">Usuários</a>
        <a href="usuariologado.php" class="text">Log</a>
        <a href="Cardapio.php" class="text">Vendas</a>
      </div>
      <div class="usuario-box" onclick="alternarSair()">
        
        <img id="usuario" src="https://img.icons8.com/ios-filled/50/FFFFFF/user-male-circle.png" alt="Usuário">
        <button id="btn-sair" onclick="sair()">Sair</button>
      </div>
    </nav>
  </header>

  <main>
    <section class="dashboard">
      <h1>Painel do Administrador</h1>
      <div class="cards-grid">

        <div class="card">
          <img src="https://cdn-icons-png.flaticon.com/128/3106/3106921.png" alt="Acessos" class="card-icon">
          <h2>Acessos</h2>
          <p class="numero"><?= $total_acessos ?></p>
          <a href="usuariologado.php" class="btn-card">Ver Detalhes</a>
        </div>

        <div class="card">
          <img src="https://img.icons8.com/ios-filled/50/000000/add-user-group-man-man.png" alt="Usuários Cadastrados" class="card-icon">
          <h2>Usuários Cadastrados</h2>
          <p class="numero"><?= $total_usuarios ?></p>
          <a href="usuario.php" class="btn-card">Ver Lista</a>
        </div>

        <div class="card">
          <img src="https://img.icons8.com/ios-filled/50/000000/pizza.png" alt="Histórico de Pedidos" class="card-icon">
          <h2>Histórico de Pedidos</h2>
          <p class="numero">0 hoje</p>
          <a href="historico-pedidos.php" class="btn-card">Ver Histórico Completo</a>
        </div>

      </div>
    </section>

    <img id="dark-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077517.png" alt="Ativar tema escuro">
    <img id="light-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077095.png" alt="Ativar tema claro" style="display:none;">
  </main>
</body>
</html>
