<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('navbar.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" type="text/css" href="css/erro.css">
     <script src="js/dark.js" defer></script>
    <script src="js/login.js" defer></script>
    <script src="js/navbar.js" defer></script>
    
</head>
<body>
   <!-- Header -->
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
          <a href="perfil.php">Editar perfil</a>
          <a href="meus-pedidos.php">Meus pedidos</a>
          <a href="logout.php">Sair</a>
        </div>

      <?php else: ?>
        <a href="Login.php" class="text">Login</a>
      <?php endif; ?>
    </div>

  </nav>
</header>

   
 <section class="dark-mode">
  <!-- Botão para ativar Dark Mode -->
              <img id="dark-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077517.png" alt="Ativar tema escuro">

  <!-- Botão para voltar ao tema claro (escondido inicialmente) -->
              <img id="light-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077095.png" alt="Ativar tema claro" style="display: none;">
 </section>
        
    </main>
   <img src="imagens/erro.png" id="img-erro" alt="Erro">
<button class="btn" onclick="window.location.href='Home.html'">Voltar para o Home</button>

</body>
</html>
