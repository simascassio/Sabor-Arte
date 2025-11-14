<?php
$host = "localhost";  
$user = "root";      
$pass = "";            
$bd   = "crud_clientes";

$mysqli = new mysqli($host, $user, $pass, $bd);

if ($mysqli->connect_errno) {
    die("❌ Falha na conexão com o banco de dados: " . $mysqli->connect_error);
}

function formatar_data($data){
    return implode ('/', array_reverse(explode('-',$data)));
}

?>
