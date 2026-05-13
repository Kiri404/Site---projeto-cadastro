<?php

include("conexao.php");

$descricao= $_POST['descricao'];

//print_r($_POST);

if($descricao == ''){
    die('informe a descrição');
}

$sql = "insert into generos (descricao) values (?)";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("s",$descricao);
    if(!$stmt->execute()){
        die("erro ao inserir a descricao");
    }
    
    header("Location: cadastrarGenero.php");
}else{
    echo 'erro na sql';
}

?>