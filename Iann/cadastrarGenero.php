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
            min-height: 100vh;
        }

        .container {
            background: #fff;
            width: 85%;
            margin: 40px auto;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        header {
            background-color: blue;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 1.5em;
        }

        .main {
            display: flex;
            min-height: 400px;
        }

        .menu {
            width: 25%;
            background: #f4f4f4;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .content {
            width: 75%;
            padding: 20px;
        }

        /* Correção da Tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .header-table {
            background-color: #eee;
            font-weight: bold;
        }

        .sair {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            background: #ff4d4d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        form { margin: 0; }
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
            <a href="cadastrarGenero.php">Cadastrar Usuário</a> <br>
            <a href="cadastrarGenero.php">Cadastrar Gênero/Filme</a>
            
        </aside>

        <section class="content">
            <h1>Cadastro</h1>
            <form method="post" action="InserirGenero.php">
                DESCRIÇÃO: <input type="text" name="descricao">
                <input type="submit" value="inserir">
            </form>

            <hr>
            <h2>Listagem de gêneros de filme</h2>

            <table>
                <tr class="header-table">
                    <td>GÊNERO</td>
                    <td>ALTERAR</td>
                    <td>APAGAR</td>
                </tr>

                <?php    
                include("conexao.php");
                
                $sql = "SELECT * FROM generos";
                $stmt = $conn->prepare($sql);

                if($stmt){
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                ?>
                            <tr>
                                <td><?= $row['descricao']; ?></td>
                                <td><a href="#">ALTERAR</a></td>
                                <td>
                                    <form method="post" action="apagarGenero.php">
                                        <input type="hidden" value="<?= $row['genero']; ?>" name="genero">
                                        <input type="submit" value="apagar" style="background:red; color:white; border:none; padding:5px; cursor:pointer;">
                                    </form>
                                </td>
                            </tr> 
                <?php           
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhum dado encontrado</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Erro na SQL: " . $conn->error . "</td></tr>";
                }
                ?>
            </table>
        </section> </div> <div style="padding: 10px; text-align: right;">
        <a class="sair" href="sair.php">Sair</a>
    </div>
</div>

</body>
</html>