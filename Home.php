<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

 ?>


<!DOCTYPE html>
<html lang="pt-br">
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/dark.js" defer></script>
    <script src="js/login.js" defer></script>
    <script src="js/navbar.js" defer></script>
    <title>Home</title>
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
        <section class="container-1">
            <div class="conteudo-texto">
                <h1>Bateu a fome ? A gente resolve com pizza !</h1>
                <a href="Cardapio.php" class="btn-cardapio"> Confira o Cardápio</a>
                
            </div>
            </div> 
            <div class="imagem-pizza">
                <img src="imagens/pizzahome.svg" alt="pizza home">
            </div>
        </section>
         <section class="dark-mode">
  <!-- Botão para ativar Dark Mode -->
              <img id="dark-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077517.png" alt="Ativar tema escuro">

  <!-- Botão para voltar ao tema claro (escondido inicialmente) -->
              <img id="light-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077095.png" alt="Ativar tema claro" style="display: none;">
        </section>
        <section class="container-2">
            <h2> O melhor sabor da cidade !</h2>
         <div class="icones-container">
            <div class="icone">
                <img src="imagens/entregador.svg" alt="">
                <p>Seu pedido a 2 toques de distancia!</p>
            </div>
            <div class="icone">
                <img src="imagens/entregado2.svg" alt="">
                <p>Da nossa cozinha pra a sua mesa em minutos </p>
            </div>
            <div class="icone">
                <img src="imagens/entregado3.svg" alt="">
                <p>Qualidade em primeiro lugar sempre!</p>
            </div>
         </div>
         <section class="quem-somos">
            <div class="sobre-nos">
                <h2>Quem somos nós?</h2>
                <p>
                    Na <strong>Pizzaria Sabor & Arte</strong>, a paixão pela pizza vai muito além de um simples prato. Somos uma equipe dedicada de pizzaiolos que se empenham todos os dias para criar experiências inesquecíveis para os nossos clientes. Cada pizza é preparada com ingredientes frescos, selecionados com carinho e assada na temperatura ideal para garantir o sabor perfeito a cada mordida.
                </p>
                <p>
                    Nossa missão é proporcionar o melhor sabor da cidade, com uma variedade de opções que agradam a todos os gostos, desde as tradicionais pizzas até as mais inovadoras criações. Estamos sempre buscando inovar e trazer algo novo para o seu paladar, mas sem perder a qualidade que nos tornou a preferida de muitos.
                </p>
                <p>
                    Com um ambiente acolhedor e uma equipe pronta para atender com muito carinho, a <strong>Pizzaria Sabor & Arte</strong> é o lugar ideal para quem busca um momento de prazer e sabor. Seja para um encontro com amigos, uma reunião de família ou uma noite solo para relaxar, temos a pizza certa para você.
                </p>
                <p>
                    Nosso compromisso é com a qualidade e com o seu prazer. Estamos prontos para fazer da sua refeição uma experiência única e deliciosa!
                </p>
            </div>
        </section>
        <section class="avaliacoes">
            <h2>Avaliações dos Clientes</h2>
            <div class="avaliacoes-container">
            
              <!-- Avaliação 1 -->
              <div class="avaliacao">
                <img src="imagens/carlos.svg" alt="Carlos Silva" class="foto-cliente">
                <div class="texto-avaliacao">
                  <p class="comentario">
                    "A melhor pizzaria da cidade! Ingredientes sempre frescos, atendimento impecável e entrega no tempo certo. Recomendo muito!"
                  </p>
                  <p class="estrelas">★★★★★</p>
                  <span>— Carlos Silva</span>
                </div>
              </div>
            
              <!-- Avaliação 2 -->
              <div class="avaliacao" id="maria">
                <img src="imagens/maria.svg" alt="Maria Oliveira" class="foto-cliente" >
                <div class="texto-avaliacao">
                  <p class="comentario">
                    "Experiência maravilhosa! As pizzas são extremamente saborosas e chegaram quentinhas. Já virei cliente fiel!"
                  </p>
                  <p class="estrelas">★★★★★</p>
                  <span>— Maria Oliveira</span>
                </div>
              </div>
              <div class="seta">
                <img
                  src="imagens/seta.svg"
                  alt="Seta para a direita"
                  id="seta-dir"
                  onclick="rolarParaDireita()"
                >
              </div>
              
              <div class="seta">
                <img
                  src="imagens/seta-esq.svg"
                  alt="Seta para a esquerda"
                  id="seta-esq"
                  onclick="rolarParaEsquerda()"
                  style="display: none;"    
>
              </div>
              <!-- Avaliação 3 (escondida por padrão, será ativada via JS) -->
              <div class="avaliacao-hidden" id="julia">
                <img src="imagens/julia.svg" alt="Julia Lima" class="foto-cliente" >
                <div class="texto-avaliacao">
                  <p class="comentario">
                    "Comi chorando de felicidade! A pizza doce é sensacional e o atendimento é muito gentil. Voltarei sempre!"
                  </p>
                  <p class="estrelas">★★★★★</p>
                  <span>— Julia Lima</span>
                </div>
              </div>
            </div>
              
        
          </section>
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
              <div class="icones-redes" id="redes">
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
    <script>
  document.addEventListener('DOMContentLoaded', () => {
  const maria   = document.getElementById('maria');
  const julia   = document.getElementById('julia');
  const setaDir = document.getElementById('seta-dir');
  const setaEsq = document.getElementById('seta-esq');

  window.rolarParaDireita = function() {
    // Esconde Maria e mostra Júlia usando flex
    maria.style.display   = 'none';
    julia.style.display   = 'flex';

    // Setas: direita some, esquerda aparece
    setaDir.style.display = 'none';
    setaEsq.style.display = 'flex';
  };

  window.rolarParaEsquerda = function() {
    // Traz Maria de volta e esconde Júlia
    maria.style.display   = 'flex';
    julia.style.display   = 'none';

    // Setas: volta a direita, oculta esquerda
    setaDir.style.display = 'flex';
    setaEsq.style.display = 'none';
  };
});

          </script>
          <script src="js/darkmode.js"></script>
          
</html>