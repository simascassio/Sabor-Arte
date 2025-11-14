<?php
session_start();
include(__DIR__ . '/../conexao.php');

// -------------------- CONFIGURAÇÃO --------------------
$itens_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($pagina_atual - 1) * $itens_por_pagina;
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : "";

// -------------------- FILTRO DE BUSCA --------------------
$where = "";
if ($busca !== "") {
    $busca = $mysqli->real_escape_string($busca);
    $where = "WHERE 
        usuario LIKE '%$busca%' OR
        ip LIKE '%$busca%' OR
        navegador LIKE '%$busca%' OR
        data_acesso LIKE '%$busca%'";
}

// -------------------- CONSULTA TOTAL --------------------
$sql_total = "SELECT COUNT(*) as total FROM acessos $where";
$total_result = $mysqli->query($sql_total);
$total_row = $total_result->fetch_assoc();
$total_registros = $total_row['total'];
$total_paginas = ceil($total_registros / $itens_por_pagina);

// -------------------- CONSULTA PRINCIPAL --------------------
$sql_acessos = "SELECT * FROM acessos $where ORDER BY id DESC LIMIT $itens_por_pagina OFFSET $offset";
$query_acessos = $mysqli->query($sql_acessos) or die("Erro: " . $mysqli->error);
$num_acessos = $query_acessos->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuario.css">
    <script src="js/dark.js" defer></script>
    <title>Logs de Acesso</title>
</head>
<body>
  <header class="opcoes">
    <nav class="container-navbar">
      <div class="nav-esquerda">
        <a href="home-adm.php" class="text">Home</a>
        <a href="usuario.php" class="text">Usuários</a>
        <a href="usuariologado.php" class="text active">Log</a>
        <a href="" class="text">Vendas</a>
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
        <h1>Logs de Acesso</h1>
    </section>

    <div class="search-container">
        <form method="get" action="">
            <input type="text" name="busca" placeholder="Pesquisar log..." value="<?php echo htmlspecialchars($busca); ?>">
            <button type="submit">Buscar</button>
            <?php if ($busca): ?>
                <a href="acessos.php" class="clear-search">Limpar</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="results-info">
        Mostrando <?php echo $num_acessos; ?> de <?php echo $total_registros; ?> registros
        <?php if ($busca): ?> para "<strong><?php echo htmlspecialchars($busca); ?></strong>"<?php endif; ?>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>IP</th>
                    <th>Navegador</th>
                    <th>Data de Acesso</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($num_acessos == 0): ?>
                    <tr><td colspan="5" class="no-results">
                        <?php echo $busca ? "Nenhum resultado para '<strong>$busca</strong>'." : "Nenhum acesso registrado."; ?>
                    </td></tr>
                <?php else: while ($acesso = $query_acessos->fetch_assoc()): ?>
                    <tr>
                        <td data-label="ID"><?php echo $acesso['id']; ?></td>
                        <td data-label="Usuário"><?php echo htmlspecialchars($acesso['usuario']); ?></td>
                        <td data-label="IP"><?php echo htmlspecialchars($acesso['ip']); ?></td>
                        <td data-label="Navegador"><?php echo htmlspecialchars($acesso['navegador']); ?></td>
                        <td data-label="Data de Acesso"><?php echo date("d/m/Y H:i:s", strtotime($acesso['data_acesso'])); ?></td>
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
    
    <img id="dark-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077517.png" alt="Ativar tema escuro">
    <img id="light-btn" src="https://cdn-icons-png.flaticon.com/128/6077/6077095.png" alt="Ativar tema claro" style="display:none;">
</main>
</body>
</html>
