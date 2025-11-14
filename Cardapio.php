<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <link rel="stylesheet" href="css/cardapio.css">
     <script src="js/dark.js" defer></script>
     <script src="js/cardapio.js" defer></script>
     <script src="js/login.js" defer></script>
     <script src="js/navbar.js" defer></script>
</head>
<body>
    <!-- Header -->
<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

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

    <!-- Conteúdo principal -->
    <main class="container">
        <h1>Cardápio</h1>

    <!-- Seção de Pizzas -->
        <section class="menu-section" aria-label="Pizzas" id="pizzas">
            <h2>Pizzas</h2>
            <div class="grid">
                <!-- Pizza Margherita -->
                <div class="item">
                    <img src="https://st4.depositphotos.com/10614052/19669/i/450/depositphotos_196695200-stock-photo-tasty-pizza-white-background.jpg" alt="Pizza Margherita">
                    <h3>Margherita</h3>
                    <p>Molho de tomate, mussarela, manjericão.</p>
                    <p><strong class="preco">Preço:</strong>  </p>
                    <div class="opcoes-item">
                        <label>Tamanho:</label>
                        <select class="tamanho">
                            <option>P</option>
                            <option>M</option>
                            <option>G</option>
                        </select>
                        <label>Quantidade:</label>
                        <input type="number" min="1" value="1" class="qntd">
                      
                    </div>
                    <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
                </div>
        
                <!-- Calabresa -->
                <div class="item">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRzQiJi8DDCsP9MtuRmTTHMaEfaRHl7LY-dSB7jwwN00w&s&ec=72940543" alt="Pizza Calabresa">
                    <h3>Calabresa</h3>
                    <p>Molho de tomate, calabresa, cebola.</p>
                    <p><strong class="preco">Preço:</strong>  </p>
                    <div class="opcoes-item">
                        <label>Tamanho:</label>
                        <select class="tamanho">
                            <option>P</option>
                            <option>M</option>
                            <option>G</option>
                        </select>
                        <label>Quantidade:</label>
                        <input type="number" min="1" value="1" class="qntd">
                    </div>
                     <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
                       

                </div>
        
                <!-- Portuguesa -->
                <div class="item">
                    <img src="https://img.freepik.com/fotos-gratis/pizza-vegetariana-com-tomate-abobrinha-e-cogumelos-isolados-no-fundo-branco_123827-21604.jpg?t=st=1745614648~exp=1745618248~hmac=2b945b80f412eea7ce8df3310d9b2c2bc53c33de46f04e3e5df8fbe9c3a47e9f&w=996" alt="Pizza Portuguesa">
                    <h3>Portuguesa</h3>
                    <p>Molho de tomate, presunto, cebola e pimentão.</p>
                    <p><strong class="preco">Preço:</strong>  </p>
                    <div class="opcoes-item">
                        <label>Tamanho:</label>
                        <select class="tamanho">
                            <option>P</option>
                            <option>M</option>
                            <option>G</option>
                        </select>
                        <label>Quantidade:</label>
                        <input type="number" min="1" value="1" class="qntd">
                    </div>
                     <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
                </div>
        
                
                <!-- Quatro Queijos -->
                <div class="item">
                    <img src="https://img.freepik.com/fotos-premium/saborosa-pizza-de-queijo-quente-no-fundo-branco_495423-60622.jpg?w=740" alt="Pizza Quatro Queijos">
                    <h3>Quatro Queijos</h3>
                    <p>Mussarela, parmesão, gorgonzola e catupiry.</p>
                    <p><strong class="preco">Preço:</strong>  </p>
                    <div class="opcoes-item">
                        <label>Tamanho:</label>
                        <select class="tamanho">
                            <option>P</option>
                            <option>M</option>
                            <option>G</option>
                        </select>
                        <label>Quantidade:</label>
                        <input type="number" min="1" value="1" class="qntd">
                    </div>
                     <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
                </div>
        
                <!-- Frango com Catupiry -->
                <div class="item">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdFmuTEtR-caU2lvl30juKrmmEU8qH_AwUmKSKXEb7Dw&s&ec=72940543" alt="Pizza Frango com Catupiry">
                    <h3>Frango  Com Catupiry</h3>
                    <p>Frango desfiado, catupiry, milho e azeitonas.</p>
                    <p><strong class="preco">Preço:</strong>   </p>
                    <div class="opcoes-item">
                        <label>Tamanho:</label>
                        <select class="tamanho">
                            <option>P</option>
                            <option>M</option>
                            <option>G</option>
                        </select>
                        <label>Quantidade:</label>
                        <input type="number" min="1" value="1" class="qntd">
                    </div>
                     <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
                </div>
        
                <!-- Peperoni -->
                <div class="item">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwuCP5Md_WfGr4jh3YzA2RB4-ZPJrlwOp0LUb4qMJFDA&s&ec=72940543" alt="Pizza Pepperoni">
                    <h3>Peperoni</h3>
                    <p>Molho de tomate, mussarela, peperoni.</p>
                    <p><strong class="preco">Preço:</strong>   </p>
                    <div class="opcoes-item">
                        <label>Tamanho:</label>
                        <select class="tamanho">
                            <option>P</option>
                            <option>M</option>
                            <option>G</option>
                        </select>
                        <label>Quantidade:</label>
                        <input type="number" min="1" value="1" class="qntd">
                    </div>
                     <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
                </div>
            </div>
        </section>

        
         <section class="dark-mode">
  <!-- Botão para ativar Dark Mode -->
  <img id="dark-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077517.png" alt="Ativar tema escuro">

  <!-- Botão para voltar ao tema claro (escondido inicialmente) -->
  <img id="light-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077095.png" alt="Ativar tema claro" style="display: none;">
</section>

        <!-- Seção de Bebidas -->
<section class="menu-section" aria-label="Bebidas" id="bebidas">
  <h2>Bebidas</h2>
  <div class="grid">

    <!-- Refrigerante 350 ml -->
    <div class="item">
      <img class="img-menor" id="coca" src="data:image/jpeg;base64,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" alt="Refrigerante 350 ml" alt="Refrigerante 350 ml">
      <img style="display: none;" class="img-menor" id="sprite" src="data:image/jpeg;base64,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" alt="">
      <img style="display: none;" class="img-menor" id="pepsi" src="data:image/jpeg;base64,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" alt="">
      <h3>Refrigerante 350 ml</h3>
      <select id="refri-lata">
        <option value="cocaLata">Coca-Cola</option>
        <option value="pepsiLata">Pepsi</option>
        <option value="spriteLata">Sprite</option>
      </select>
      <p><strong>Preço: <span class="preco-valor">R$ 5,00</span> </strong></p>
      <div class="opcoes-item">
        <label>Quantidade:</label>
        <input type="number" min="1" value="1" class="qntd-dinamica">
      </div>
       <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
    </div>

    <!-- Refrigerante 2 Litros -->
    <div class="item">
      <img class="img-menor" id="cocaLitro" src="data:image/jpeg;base64,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" alt="Refrigerante 2 Litros" alt="Refrigerante 2 Litros">
      <img style="display: none;" class="img-menor" id="pepsiLitro" src="data:image/jpeg;base64,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" alt="">
      <img  style="display: none;" class="img-menor"  id="spriteLitro" src="data:image/jpeg;base64,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" alt="">  
      <h3>Refrigerante 2 Litros</h3>
      <select id="refri-pet">
        <option value="coca-litro">Coca-Cola</option>
        <option value="pepsi-litro">Pepsi</option>
        <option value="sprite-litro">Sprite</option>
      </select>
      <p><strong>Preço: <span class="preco-valor">R$ 14,00 </strong></span></p>
      <div class="opcoes-item">
        <label>Quantidade:</label>
        <input type="number" min="1" value="1" class="qntd-dinamica">
      </div>
       <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
    </div>

    <!-- Guaracamp -->
    <div class="item">
      <img class="img-menor" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLhQ8dknm9LT8vbomPmPeIGQ-O90b_WsNtIrRWYnVT27LBZVS7uZ1Op73pQ4IAn67UlX0&usqp=CAU" alt="Guaracamp">
      <h3>Guaracamp</h3>
      <select>
        <option value="">Natural</option>
    
      </select>
      <p><strong>Preço: <span class="preco-valor">R$ 3,50 </strong></span></p>
      <div class="opcoes-item">
        <label>Quantidade:</label>
        <input type="number" min="1" value="1" class="qntd-dinamica">
      </div>
       <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
    </div>
    
  </div>
</section>

<!-- Seção de Sobremesas -->
<section class="menu-section" aria-label="Sobremesas" id="sobremesas">
  <h2>Sobremesas</h2>
  <div class="grid">

    <!-- Torta de Limão -->
    <div class="item">
      <img class="img-menor" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThd8UphI_jI_UVLO0HY_Sffu3XfkxiAzoz_Cpp55Jn6g&s&ec=72940543" alt="Torta de Limão">
      <h3>Torta de Limão</h3>
      <p>Torta com creme de limão e chantilly.</p>
      <p><strong>Preço: <span class="preco-valor">R$ 15,50 </strong></span></p>
      <div class="opcoes-item">
        <label>Quantidade:</label>
        <input type="number" min="1" value="1" class="qntd-dinamica">
      </div>
       <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
    </div>

    <!-- Brownie -->
    <div class="item">
      <img class="img-menor" src="https://img.freepik.com/fotos-gratis/porcao-de-brownie-de-chocolate-isolada-em-fundo-branco_123827-27904.jpg?semt=ais_hybrid&w=740" alt="Brownie">
      <h3>Brownie</h3>
      <p>Bolo de chocolate com pedaços de nozes.</p>
      <p><strong>Preço: <span class="preco-valor">R$ 13,50</span> </strong></p>
      <div class="opcoes-item">
        <label>Quantidade:</label>
        <input type="number" min="1" value="1" class="qntd-dinamica">
      </div>
       <button class="btn-adicionar" onclick="adicionarPedido(this)">Adicionar</button>
    </div>
  </div>
</section>


        <!-- meu pedido -->
         <section class="lista-pedido" id="pedido">
        <div class="title-pedido">
          
            <img src="https://cdn-icons-png.freepik.com/256/384/384990.png?ga=GA1.1.1350957922.1743372057&semt=ais_hybrid" alt="" class="pedido-icon">
            <h3> Seu Pedido</h3>
        </div>

        <!-- Área onde os itens adicionados aparecerão -->
        <div class="pedido">
            <p class="pedido-vazio">Nenhum item foi selecionada ainda.</p>
        </div>

        <!-- Total do pedido -->
        <div class="total-pedido">  
            <span>Total: R$ <span id="total"> 0,00</span></span>
        </div>

        <!-- Botões para limpar ou finalizar o pedido -->
        <div class="btn-pedido">
            <button onclick="limparPedido()" id="limpar-btn">Limpar Pedido</button>
            <button onclick="finalizarPedido()" id="finalizar-btn">Finalizar Pedido</button>
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
              <div class="icones-redes">
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