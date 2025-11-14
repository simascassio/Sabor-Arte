<?php
session_start(); // PRECISA vir antes de qualquer coisa

// Apaga todos os dados da sessão
$_SESSION = [];
session_unset();
session_destroy();

// Redireciona para a Home
header("Location: Home.php");
exit;
?>

