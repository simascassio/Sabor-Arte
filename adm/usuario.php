<?php
session_start();
include(__DIR__ . '/../conexao.php');


$itens_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($pagina_atual - 1) * $itens_por_pagina;


$busca = isset($_GET['busca']) ? trim($_GET['busca']) : "";


$where = "";
if ($busca !== "") {
    $busca = $mysqli->real_escape_string($busca);
    $where = "WHERE 
        id LIKE '%$busca%' OR
        nome LIKE '%$busca%' OR
        email LIKE '%$busca%' OR
        telefone LIKE '%$busca%' OR
        telefonefixo LIKE '%$busca%' OR
        nascimento LIKE '%$busca%' OR
        data LIKE '%$busca%' OR
        CPF LIKE '%$busca%' OR
        CEP LIKE '%$busca%' OR
        Senha LIKE '%$busca%' OR
        num_casa LIKE '%$busca%' OR
        complemento LIKE '%$busca%' OR
        endereco LIKE '%$busca%' OR
        materno LIKE '%$busca%' OR
        genero LIKE '%$busca%' OR
        login LIKE '%$busca%'";
}


$sql_total = "SELECT COUNT(*) as total FROM clientes $where";
$total_result = $mysqli->query($sql_total);
$total_row = $total_result->fetch_assoc();
$total_registros = $total_row['total'];
$total_paginas = ceil($total_registros / $itens_por_pagina);


$sql_clientes = "SELECT * FROM clientes $where ORDER BY id ASC LIMIT $itens_por_pagina OFFSET $offset";
$query_clientes = $mysqli->query($sql_clientes) or die("Erro: " . $mysqli->error);
$num_clientes = $query_clientes->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuario.css">
    <script src="js/dark.js" defer></script>
    <title>Usuários</title>
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
        <span id="nome-usuario"></span>
        <img id="usuario" src="https://img.icons8.com/ios-filled/50/FFFFFF/user-male-circle.png" alt="Usuário">
        <button id="btn-sair" onclick="sair()">Sair</button>
      </div>
    </nav>
  </header>

<main>
    <section class="container-titulo">
        <h1>Usuários Cadastrados</h1>
    </section>

    <!-- Mensagens de Feedback -->
    <?php if (isset($_SESSION['sucesso'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['erro'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
    <?php endif; ?>

    
    <div class="search-container">
        <form method="get" action="">
            <input type="text" name="busca" placeholder="Pesquisar usuário..." value="<?php echo htmlspecialchars($busca); ?>">
            <button type="submit">Buscar</button>
            <?php if ($busca): ?>
                <a href="usuario.php" class="clear-search">Limpar</a>
            <?php endif; ?>
        </form>
    </div>

  
    <div class="results-info">
        Mostrando <?php echo $num_clientes; ?> de <?php echo $total_registros; ?> usuários
        <?php if ($busca): ?> para "<strong><?php echo htmlspecialchars($busca); ?></strong>"<?php endif; ?>
    </div>

   
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Nome</th><th>Email</th><th>Telefone</th><th>Tel. Fixo</th>
                    <th>Nasc.</th><th>Data</th><th>CPF</th><th>CEP</th><th>Senha</th>
                    <th>Nº Casa</th><th>Compl.</th><th>Endereço</th><th>Materno</th><th>Gênero</th>
                    <th>Login</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($num_clientes == 0): ?>
                    <tr><td colspan="17" class="no-results">
                        <?php echo $busca ? "Nenhum resultado para '<strong>$busca</strong>'." : "Nenhum usuário cadastrado."; ?>
                    </td></tr>
                <?php else: while ($clientes = $query_clientes->fetch_assoc()): 
                    $nasc = !empty($clientes['nascimento']) ? date("d/m/Y", strtotime($clientes['nascimento'])) : '';
                    $data = !empty($clientes['data']) ? date("d/m/Y", strtotime($clientes['data'])) : '';
                ?>
                    <tr>
                        <td data-label="ID"><?php echo $clientes['id']; ?></td>
                        <td data-label="Nome"><?php echo $clientes['nome']; ?></td>
                        <td data-label="Email"><?php echo $clientes['email']; ?></td>
                        <td data-label="Tel"><?php echo $clientes['telefone']; ?></td>
                        <td data-label="Fixo"><?php echo $clientes['telefonefixo']; ?></td>
                        <td data-label="Nasc."><?php echo $nasc; ?></td>
                        <td data-label="Data"><?php echo $data; ?></td>
                        <td data-label="CPF"><?php echo $clientes['CPF']; ?></td>
                        <td data-label="CEP"><?php echo $clientes['CEP']; ?></td>
                        <td data-label="Senha"><?php echo $clientes['Senha']; ?></td>
                        <td data-label="Nº"><?php echo $clientes['num_casa']; ?></td>
                        <td data-label="Compl."><?php echo $clientes['complemento']; ?></td>
                        <td data-label="End."><?php echo $clientes['endereco']; ?></td>
                        <td data-label="Materno"><?php echo $clientes['materno']; ?></td>
                        <td data-label="Gênero"><?php echo $clientes['genero']; ?></td>
                        <td data-label="Login"><?php echo $clientes['login']; ?></td>
                        <td data-label="Ações" class="acoes">
                            <a href="editar.php?id=<?php echo $clientes['id']; ?>" class="btn-editar"> ✏️ Editar</a>
                            <a class="btn-deletar" 
                               data-id="<?php echo $clientes['id']; ?>" 
                               data-nome="<?php echo htmlspecialchars($clientes['nome']); ?>">
                              🗑️ Deletar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>

    <!-- PAGINAÇÃO -->
    <?php if ($total_paginas > 1): ?>
    <div class="pagination">
        <?php 
        $params = $_GET;
        unset($params['pagina']);
        $base_url = http_build_query($params);
        ?>
        <?php if ($pagina_atual > 1): ?>
            <a href="?<?php echo $base_url; ?>&pagina=1" class="page-btn">Primeira</a>
            <a href="?<?php echo $base_url; ?>&pagina=<?php echo $pagina_atual - 1; ?>" class="page-btn">Anterior</a>
        <?php endif; ?>

        <?php for ($i = max(1, $pagina_atual - 2); $i <= min($total_paginas, $pagina_atual + 2); $i++): ?>
            <a href="?<?php echo $base_url; ?>&pagina=<?php echo $i; ?>" 
               class="page-btn <?php echo $i == $pagina_atual ? 'active' : ''; ?>">
               <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($pagina_atual < $total_paginas): ?>
            <a href="?<?php echo $base_url; ?>&pagina=<?php echo $pagina_atual + 1; ?>" class="page-btn">Próxima</a>
            <a href="?<?php echo $base_url; ?>&pagina=<?php echo $total_paginas; ?>" class="page-btn">Última</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Botões Dark Mode -->
    <img id="dark-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077517.png" alt="Tema escuro">
    <img id="light-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077095.png" alt="Tema claro" style="display:none;">
</main>

<!-- MODAL DE CONFIRMAÇÃO -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Confirmar Deleção</h2>
        <p>Tem certeza que deseja deletar o usuário <strong id="userName"></strong>?</p>
        <p>Esta ação <strong>não pode ser desfeita</strong>.</p>
        <form id="deleteForm" method="post" action="deletar.php">
            <input type="hidden" id="deleteId" name="id" value="">
            <div class="modal-buttons">
                <button type="submit" name="confirmar" class="btn-confirm">Sim, Deletar</button>
                <button type="button" class="btn-cancel">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('deleteModal');
    const deleteIdInput = document.getElementById('deleteId');
    const userNameSpan = document.getElementById('userName');
    const closeBtn = document.querySelector('.modal .close');
    const cancelBtn = document.querySelector('.btn-cancel');

    if (!modal || !deleteIdInput || !userNameSpan) {
        console.error('Erro: Elementos do modal não encontrados!');
        return;
    }

    document.querySelectorAll('.btn-deletar').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome') || 'este usuário';

            deleteIdInput.value = id;
            userNameSpan.textContent = nome;
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('show'), 10);
        });
    });

    function closeModal() {
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 300);
    }

    if (closeBtn) closeBtn.onclick = closeModal;
    if (cancelBtn) cancelBtn.onclick = closeModal;
    window.onclick = (e) => { if (e.target === modal) closeModal(); };
});
</script>

</body>
</html>