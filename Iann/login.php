<?php

include("conexao.php");

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];

//print_r($_POST);

if($cpf == ''){
    die('informe o cpf');
}

if($senha == ''){
    die('informe a senha');
}

$sql = "select nome from usuário where cpf = ? and senha = ?";
$stmt = $conn->prepare($sql);
if($stmt){
    $stmt->bind_param("ss",$cpf,$senha);
    $stmt->execute();
    $result = $stmt->get_result();

if($result->num_rows >0){
    $row = $result->fetch_assoc();
    if($row['nome'] != ''){
        session_start();
        $_SESSION['cpf'] = $cpf;
        $_SESSION['senha'] = $senha;
        $_SESSION['nome'] = $row['nome'];
        header("Location: principal.php");
    }else{
        echo 'usuario ou senha incorretos';
    }
}else{
    echo 'nenhum dado encontrado';
    }
}else{
    echo 'erro na sql';
}

?>