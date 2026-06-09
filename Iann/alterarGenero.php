<?php

include("conexao.php");

$descricao_antiga = $_POST['descricao_antiga'];
$descricao = $_POST['descricao'];

if($descricao == ''){
    die('informe a descrição');
}

$sql = "UPDATE generos
        SET descricao = ?
        WHERE descricao = ?";

$stmt = $conn->prepare($sql);

if($stmt){

    $stmt->bind_param("ss", $descricao, $descricao_antiga);

    if(!$stmt->execute()){
        die("erro ao alterar a descrição");
    }

    header("Location: cadastrarGenero.php");

}else{
    echo 'erro na sql';
}

?>