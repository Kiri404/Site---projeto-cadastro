<?php

include("conexao.php");

$ano = $_POST['ano'];
$genero = $_POST['generos'];
$nome = $_POST['nome'];

//print_r($_POST);

if($ano == ''){
    die('informe o ano');
}

if($genero == ''){
    die('informe o genero');
}

if($nome == ''){
    die('informe o nome');
}
if($ano<1900 || $ano>2026){
    die("o ano deve estar entre 1900 e 2026");
}
$sql = "insert into filmes (ano,nome,genero) values (?,?,?)";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("isi",$ano,$nome,$genero);
    if(!$stmt->execute()){
        die("erro ao inserir o filme");
    }
    
    header("Location: cadastrarFilmes.php");
}else{
    echo 'erro na sql';
}

?>