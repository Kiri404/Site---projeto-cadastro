<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "banco";

$conn = new mysqli ($servidor, $usuario, $senha, $dbname);

if($conn->connect_error){
   die("falha no banco ".$conn->connect_error);
}