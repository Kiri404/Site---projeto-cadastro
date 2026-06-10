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

        /* Estilo para as mensagens de erro */
        .msg-erro {
            color: #ff4d4d;
            font-size: 0.9em;
            font-weight: bold;
            margin-top: 5px;
            display: block;
        }
    </style>

    <script>
        // Algoritmo de validação oficial de CPF
        function testaCPF(strCPF) {
            var Soma = 0;
            var Resto;
            // Remove pontos, traços ou espaços
            strCPF = strCPF.replace(/[^\d]+/g, '');
            
            if (strCPF.length !== 11 || 
                /^(\d)\1{10}$/.test(strCPF)) return false; // Bloqueia CPFs com números todos iguais
                
            for (var i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;
            
            if ((Resto === 10) || (Resto === 11)) Resto = 0;
            if (Resto !== parseInt(strCPF.substring(9, 10)) ) return false;
            
            Soma = 0;
            for (var i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;
            
            if ((Resto === 10) || (Resto === 11)) Resto = 0;
            if (Resto !== parseInt(strCPF.substring(10, 11) ) ) return false;
            
            return true;
        }

        function validarUsuario(form) {
            // Remove erros passados anexados a este formulário específico
            var erroAnterior = form.querySelector('.msg-erro');
            if (erroAnterior) {
                erroAnterior.remove();
            }

            var cpfInput = form.cpf.value.trim();
            var nomeInput = form.nome.value.trim();
            var senhaInput = form.senha.value;

            // 1. Validar Nome
            if (nomeInput === "") {
                exibirErro(form, "O nome não pode ser vazio.", form.nome);
                return false;
            }

            // 2. Validar CPF
            if (!testaCPF(cpfInput)) {
                exibirErro(form, "Por favor, digite um CPF válido.", form.cpf);
                return false;
            }

            // 3. Validar Senha com RegEx
            // Mínimo 6 caracteres, pelo menos: 1 maiúscula, 1 minúscula, 1 número e 1 caractere especial
            var regexSenha = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/;
            if (!regexSenha.test(senhaInput)) {
                exibirErro(
                    form, 
                    "A senha deve conter no mínimo 6 caracteres, incluindo: 1 letra maiúscula, 1 minúscula, 1 número e 1 caractere especial.", 
                    form.senha
                );
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
            <h1>Cadastro</h1>
            
            <form method="post" action="InserirUsuario.php" onsubmit="return validarUsuario(this);">
                CPF: <input type="text" name="cpf" placeholder="Apenas números ou formato padrão">
                NOME: <input type="text" name="nome">
                SENHA: <input type="password" name="senha">
                <input type="submit" value="inserir">
            </form>

            <hr>
            <h2>Listagem de Usuarios</h2>

            <table>
                <tr class="header-table">
                    <td>CPF</td>
                    <td>NOME</td>
                    <td>SENHA</td>
                    <td>ALTERAR</td>
                    <td>APAGAR</td>
                </tr>

                <?php    
                include("conexao.php");
                
                $sql = "SELECT * FROM usuário";
                $stmt = $conn->prepare($sql);

                if($stmt){
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $cpf_val = $row['CPF'] ?? $row['cpf'] ?? '---';
                            $nome_val = $row['nome'] ?? $row['NOME'] ?? '---';
                            $senha_val = $row['senha'] ?? $row['SENHA'] ?? '---';
                ?>
                            <tr>
                                <td><?= htmlspecialchars($cpf_val); ?></td>
                                <td><?= htmlspecialchars($nome_val); ?></td>
                                <td>••••••••</td> <td>
                                    <form method="post" action="alterarUsuario.php" onsubmit="return validarUsuario(this);" 
                                          style="display:flex; flex-direction:column; gap:5px; align-items:flex-start;">
                                        
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            CPF:
                                            <input type="text" name="cpf" value="<?= htmlspecialchars($cpf_val); ?>" style="width:100px;">

                                            Nome:
                                            <input type="text" name="nome" value="<?= htmlspecialchars($nome_val); ?>" style="width:120px;">

                                            Senha:
                                            <input type="password" name="senha" value="<?= htmlspecialchars($senha_val); ?>" style="width:100px;">

                                            <input type="submit" value="Alterar">
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="apagarUsuario.php">
                                        <input type="hidden" value="<?= htmlspecialchars($cpf_val); ?>" name="cpf">
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
        </section> 
    </div> 
    
    <div style="padding: 10px; text-align: right;">
        <a class="sair" href="sair.php">Sair</a>
    </div>
</div>

</body>
</html>