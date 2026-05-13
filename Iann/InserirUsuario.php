<?php

include("conexao.php");

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$nome = $_POST['nome'];

//print_r($_POST);

if($cpf == ''){
    die('informe o cpf');
}

if($senha == ''){
    die('informe a senha');
}

if($nome == ''){
    die('informe o nome');
}
$sql = "insert into usuário (cpf,nome,senha) values (?,?,?)";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("sss",$cpf,$nome,$senha);
    if(!$stmt->execute()){
        die("erro ao inserir o usuário");
    }
    
    header("Location: cadastrarUsuario.php");
}else{
    echo 'erro na sql';
}

?>