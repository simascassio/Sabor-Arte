<?php
$host = "localhost";  // Servidor
$user = "root";       // Usuário do MySQL
$pass = "";           // Senha (vazia por padrão no XAMPP)
$bd   = "crud_clientes"; // Nome do banco de dados (mude se o seu for diferente)

$mysqli = new mysqli($host, $user, $pass, $bd);

if ($mysqli->connect_errno) {
    die("❌ Falha na conexão com o banco de dados: " . $mysqli->connect_error);
}
?>
