<?php

include("conexao.php");

$cpf = $_POST['cpf'];

if($cpf == ''){
    die('informe o cpf');
}

$sql = "delete from usuário where cpf=?";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("s",$cpf);
    if(!$stmt->execute()){
        die("erro ao apagar o usuario");
    }

    header("Location: cadastrarUsuario.php");

}else{
    echo 'erro na sql';
}

?>