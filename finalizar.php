<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/finalizar.css">
    <script src="js/finalizar.js" defer></script>
    <script src="js/dark.js" defer></script>
    <script src="js/login.js" defer></script>
    <script src="js/navbar.js" defer></script>
    <title>Finalizar Pedido</title>
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

        <main class="container-principal">
            <section  class="pedido-section" aria-label="Itens do Pedido">
                <div class="pedido-finalizar">
                    <h1> Confira os itens do seu pedido:</h1>
                    <img src="https://cdn-icons-png.freepik.com/256/2611/2611181.png?ga=GA1.1.1350957922.1743372057&semt=ais_hybrid" alt="">
                </div class="pedido-carrinho">
                    <ul id="pedido-lista">
                        <!-- Itens do pedido serão adicionados aqui dinamicamente -->
                    </ul>
                <div>
                   
                </div>
            </section>
      

        
         <section class="dark-mode">
  <!-- Botão para ativar Dark Mode -->
              <img id="dark-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077517.png" alt="Ativar tema escuro">

  <!-- Botão para voltar ao tema claro (escondido inicialmente) -->
              <img id="light-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077095.png" alt="Ativar tema claro" style="display: none;">
        </section>

    
        <!-- Seção de Endereço -->
        <section class="endereco-section" aria-label="Endereço de Entrega">
            <h2>Endereço para Entrega :</h2>
            <form id="form-endereco" class="form">
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" placeholder="00000-000" required>
                
                <label for="rua">Rua:</label>
                <input type="text" id="rua" name="rua" required>
                
                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" required>
                
                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" required>

                <label for="pagamento">Método de Pagamento:</label>
                <select id="pagamento" name="pagamento" required>
                    <option value="pix">Pix</option>
                    <option value="debito">Débito</option>
                    <option value="credito">Crédito</option>
                    <option value="dinheiro">Dinheiro</option>
                </select>

                <button type="submit" class="btn">Confirmar Pedido</button>
            </form>
        </section>
        <!-- Modal de Sucesso -->
<div id="modal-sucesso" class="modal">
  <div class="modal-conteudo">
    <span class="fechar" id="fechar-modal">&times;</span>
    <p>✅ Pedido feito com sucesso!<br>Prazo de entrega: 40 minutos.</p>
  </div>
</div>
</main>

<footer class="footer-contato">
          <div class="footer-container">
            <div class="footer-links">
              <a href="Home.html" class="footer-1">Home</a>
              <a href="Cardapio.html" class="footer-1">Cardápio</a>
              <a href="finalizar.html" class="footer-1">Pedido</a>
              <a href="cadastro.html" class="footer-1">Cadastre-se</a>
            </div>
            <div class="footer-contato-section">
              <div class="info-contato">
                <h3>Contato</h3>
              </div>
              <div id="icones-redes">
                <a href="https://instagram.com" target="_blank" aria-label="Instagram">
                  <img src="https://img.icons8.com/?size=50&id=BrU2BBoRXiWq&format=png" alt="Instagram">
                </a>
                <a href="https://wa.me/123456789" target="_blank" aria-label="WhatsApp">
                  <img src="https://img.icons8.com/?size=50&id=A1JUR9NRH7sC&format=png" alt="WhatsApp">
                </a>
             
              </div>
            </div>
          </div>
          <p id="copy">&copy; 2025 Pizzaria Sabor & Arte. Todos os direitos reservados.</p>
    </footer>
</body>
</html>