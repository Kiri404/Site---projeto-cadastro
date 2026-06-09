<?php


include("conexao.php");




$filme = $_POST['filme'];
$ano = $_POST['ano'];
$nome = $_POST['nome'];
$genero = $_POST['generos'];

if($ano == ''){
    die('informe o ano');
}

if($genero == ''){
    die('informe o genero');
}

if($nome == ''){
    die('informe o nome');
}

$sql = "UPDATE filmes
        SET ano = ?,
            nome = ?,
            genero = ?
        WHERE filme = ?";

$stmt = $conn->prepare($sql);

if($stmt){

    $stmt->bind_param("isii", $ano, $nome, $genero, $filme);

    if(!$stmt->execute()){
        die("erro ao alterar o filme");
    }

    header("Location: cadastrarFilmes.php");

}else{
    echo 'erro na sql';
}

?>