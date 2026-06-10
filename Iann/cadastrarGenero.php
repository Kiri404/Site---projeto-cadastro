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

        /* Estilo para exibição das mensagens de erro na página */
        .msg-erro {
            color: #ff4d4d;
            font-size: 0.9em;
            font-weight: bold;
            margin-top: 5px;
            display: block;
        }
    </style>

    <script>
        function validarGenero(form) {
            // Remove mensagens de erro antigas anexadas a este formulário específico
            var erroAnterior = form.querySelector('.msg-erro');
            if (erroAnterior) {
                erroAnterior.remove();
            }

            // Obtém o valor limpando espaços extras nas pontas
            var descricaoInput = form.descricao.value.trim();

            // Validação: Não pode ser vazio
            if (descricaoInput === "") {
                var spanErro = document.createElement('span');
                spanErro.className = 'msg-erro';
                spanErro.innerText = "A descrição do gênero não pode ficar vazia.";
                
                form.appendChild(spanErro);
                form.descricao.focus();
                return false; // Bloqueia o envio do formulário
            }

            return true; // Permite o envio se estiver preenchido
        }
    </script>
</head>
<body>

<div class="container">
    <header>Página Principal</header>

    <div class="main">
        <aside class="menu">
            <h2>Menu</h2>
            <a href="principal.php">Início</a> <br>
            <a href="cadastrarUsuario.php">Cadastrar Usuário</a> <br>
            <a href="cadastrarGenero.php">Cadastrar Gênero</a> <br>
            <a href="cadastrarFilmes.php">Cadastrar Filme</a>
        </aside>

        <section class="content">
            <h1>Cadastro</h1>

            <?php if (isset($_GET['erro'])): ?>
                <span class="msg-erro" style="margin-bottom: 15px;">
                    <?= htmlspecialchars($_GET['erro']); ?>
                </span>
            <?php endif; ?>

            <form method="post" action="InserirGenero.php" onsubmit="return validarGenero(this);">
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
                                <td><?= htmlspecialchars($row['descricao']); ?></td>
                                <td>
                                    <form method="post" action="alterarGenero.php" onsubmit="return validarGenero(this);" 
                                          style="display:flex; flex-direction:column; gap:3px; align-items:flex-start;">
                                        
                                        <div style="display:flex; gap:10px; align-items:center;">
                                            <input type="hidden" name="descricao_antiga" value="<?= htmlspecialchars($row['descricao']); ?>">
                                            <input type="text" name="descricao" value="<?= htmlspecialchars($row['descricao']); ?>">
                                            <input type="submit" value="Alterar">
                                        </div>
                                    </form>
                                </td>
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
                        echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Erro na SQL: " . $conn->error . "</td></tr>";
                }
                ?>
            </table>
        </section> 
    </div> 
    
    <div style="padding: 10px; text-align: right;">
        <a class="sair" href="sair.php">Sair</a>
    </div>
</div>

</body>
</html>