<?php

include("conexao.php");

$genero = $_POST['genero'];

if($genero == ''){
    die('informe o genero');
}

$sql = "delete from generos where genero=?";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("i",$genero);
    if(!$stmt->execute()){
        die("erro ao apagar o genero");
    }

    header("Location: cadastrarGenero.php");

}else{
    echo 'erro na sql';
}

?>