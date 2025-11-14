<?php
session_start();
include(__DIR__ . '/../conexao.php');

// DEBUG TEMPORÁRIO - REMOVE DEPOIS
error_log("POST recebido: " . print_r($_POST, true));
error_log("ID recebido: " . (isset($_POST['id']) ? $_POST['id'] : 'NÃO EXISTE'));
error_log("É numérico: " . (isset($_POST['id']) && is_numeric($_POST['id']) ? 'SIM' : 'NÃO'));

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    $_SESSION['erro'] = "ID inválido. DEBUG: ID=" . (isset($_POST['id']) ? $_POST['id'] : 'NULO');
    header("Location: usuario.php");
    exit;
}

$id = intval($_POST['id']);

if (isset($_POST['confirmar'])) {
    $sql = "DELETE FROM clientes WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['sucesso'] = "Usuário deletado com sucesso! ID: $id";
    } else {
        $_SESSION['erro'] = "Erro ao deletar o usuário. ID: $id";
    }
    $stmt->close();
} else {
    $_SESSION['erro'] = "Ação cancelada.";
}

header("Location: usuario.php");
exit;
?>

