<?php
include("valida.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>

    <style>
        body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #00eb4e, #0073df);
}

.container {
    background: #fff;
    width: 80%;
    margin: 40px auto;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    overflow: hidden;
}

/* Header */
header {
    background-color: blue;
    color: #fff;
    padding: 20px;
    text-align: center;
}

/* Layout lado a lado */
.main {
    display: flex;
    min-height: 400px;
}

/* Menu esquerda */
.menu {
    width: 25%;
    background: #f4f4f4;
    padding: 20px;
}

/* Conteúdo direita */
.content {
    width: 75%;
    padding: 20px;
}

/* Estilos extras */
.user {
    font-weight: bold;
    color: #003bfd;
}

.sair {
    display: inline-block;
    margin: 20px;
    padding: 10px 20px;
    background: #ff4d4d;
    color: #fff;
    border-radius: 5px;
}
    </style>
</head>
<body>

<div class="container">
    <header>Página Principal</header>

    <div class="main">
        <aside class="menu">
            <h2>Menu</h2>
            <a href="principal.php">Início</a>
            <br>
            <a href="cadastrarUsuario.php">Cadastrar Usuário</a> <br>
            <a href="cadastrarGenero.php">Cadastrar Gênero/Filme</a>
        </aside>

        <section class="content">
            <p>Olá, <span class="user"><?php echo $_SESSION['nome']; ?></span></p>
            <h1>Bem-vindo</h1>

            <h2>Conteúdo</h2>
            <p>Aqui vai o conteúdo da página...</p>
        </section>
    </div>

    <hr>
    <a class="sair" href="sair.php">Sair</a>
</div>


</body>
</html>