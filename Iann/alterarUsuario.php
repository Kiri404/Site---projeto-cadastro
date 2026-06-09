<?php

include("conexao.php");

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$nome = $_POST['nome'];

if($cpf == ''){
    die('informe o cpf');
}

if($senha == ''){
    die('informe a senha');
}

if($nome == ''){
    die('informe o nome');
}

$sql = "UPDATE usuário
        SET nome = ?, senha = ?
        WHERE cpf = ?";

$stmt = $conn->prepare($sql);

if($stmt){

    $stmt->bind_param("sss", $nome, $senha, $cpf);

    if(!$stmt->execute()){
        die("erro ao alterar o usuário");
    }

    header("Location: cadastrarUsuario.php");

}else{
    echo 'erro na sql';
}

?>