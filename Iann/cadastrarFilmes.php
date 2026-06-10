<?php
include("valida.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Filmes</title>

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

        form {
            margin: 0;
        }

        /* Estilo da mensagem de erro */
        .msg-erro {
            color: #ff4d4d;
            font-size: 0.9em;
            font-weight: bold;
            margin-top: 5px;
            display: block;
        }
    </style>

    <script>
        function validarFormulario(form) {
            // Remove erros anteriores do formulário que chamou a validação
            var erroAnterior = form.querySelector('.msg-erro');
            if (erroAnterior) {
                erroAnterior.remove();
            }

            var anoInput = form.ano.value.trim();
            var generoInput = form.generos.value;
            var anoAtual = new Date().getFullYear();
            var mensagem = "";

            // Validação do Gênero
            if (generoInput === "") {
                mensagem = "Por favor, selecione um gênero.";
                exibirErro(form, mensagem, form.generos);
                return false;
            }

            // Validação do Ano
            var anoNum = parseInt(anoInput, 10);
            if (isNaN(anoNum) || anoNum < 1900 || anoNum > anoAtual) {
                mensagem = "Insira um ano válido entre 1900 e " + anoAtual + ".";
                exibirErro(form, mensagem, form.ano);
                return false;
            }

            return true;
        }

        function exibirErro(form, texto, campoFoco) {
            var spanErro = document.createElement('span');
            spanErro.className = 'msg-erro';
            spanErro.innerText = texto;
            form.appendChild(spanErro);
            campoFoco.focus();
        }
    </script>
</head>
<body>

<div class="container">

    <header>Página Principal</header>

    <div class="main">

        <aside class="menu">
            <h2>Menu</h2>
            <a href="principal.php">Início</a><br>
            <a href="cadastrarUsuario.php">Cadastrar Usuário</a><br>
            <a href="cadastrarGenero.php">Cadastrar Gênero</a><br>
            <a href="cadastrarFilmes.php">Cadastrar Filme</a>
        </aside>

        <section class="content">

            <h1>Cadastro de Filme</h1>

            <form method="post" action="InserirFilmes.php" onsubmit="return validarFormulario(this);">

                NOME:
                <input type="text" name="nome" required>

                ANO:
                <input type="text" name="ano">

                GÊNERO:
                <select name="generos">
                    <option value="">Selecione</option>

                    <?php
                    include("conexao.php");

                    $sql = "SELECT * FROM generos";
                    $stmt = $conn->prepare($sql);

                    if($stmt){
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while($rowGenero = $result->fetch_assoc()){
                    ?>
                        <option value="<?= $rowGenero['genero']; ?>">
                            <?= $rowGenero['descricao']; ?>
                        </option>
                    <?php
                        }
                    }
                    ?>
                </select>

                <input type="submit" value="Inserir">

            </form>

            <hr>

            <h2>Listagem de Filmes</h2>

            <table>
                <tr class="header-table">
                    <td>FILME</td>
                    <td>ALTERAR</td>
                    <td>APAGAR</td>
                </tr>

                <?php
                $sql = "SELECT * FROM filmes";
                $stmt = $conn->prepare($sql);

                if($stmt){
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while($row = $result->fetch_assoc()){
                ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($row['nome']); ?>
                    </td>

                    <td>
                        <form method="post" action="alterarFilme.php" onsubmit="return validarFormulario(this);"
                              style="display:flex; flex-direction:column; gap:5px; align-items:flex-start;">
                            
                            <div style="display:flex; gap:10px; align-items:center;">
                                <input type="hidden" name="filme" value="<?= $row['filme']; ?>">

                                <input type="text" name="nome" value="<?= htmlspecialchars($row['nome']); ?>" required>

                                <input type="text" name="ano" value="<?= $row['ano']; ?>">

                                <select name="generos">
                                    <?php
                                    $sqlGenero = "SELECT * FROM generos";
                                    $stmtGenero = $conn->prepare($sqlGenero);

                                    if($stmtGenero){
                                        $stmtGenero->execute();
                                        $resultGenero = $stmtGenero->get_result();

                                        while($rowGenero = $resultGenero->fetch_assoc()){
                                            $selected = ($rowGenero['genero'] == $row['genero']) ? "selected" : "";
                                    ?>
                                            <option value="<?= $rowGenero['genero']; ?>" <?= $selected; ?>>
                                                <?= htmlspecialchars($rowGenero['descricao']); ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>

                                <input type="submit" value="Alterar">
                            </div>
                        </form>
                    </td>

                    <td>
                        <form method="post" action="apagarFilme.php">
                            <input type="hidden" name="filme" value="<?= $row['filme']; ?>">
                            <input type="submit" value="Apagar"
                                   style="background:red;color:white;border:none;padding:5px;cursor:pointer;">
                        </form>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
            </table>

        </section>

    </div>

    <div style="padding:10px;text-align:right;">
        <a class="sair" href="sair.php">Sair</a>
    </div>

</div>

</body>
</html>