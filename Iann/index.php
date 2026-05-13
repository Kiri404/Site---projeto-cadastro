<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #70ffd4ff, #00eb4eff);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px 1px 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"] {
            background: #4facfe;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #00c6ff;
        }

        label {
            display: block;
            text-align: left;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Login do Sistema</h2>

        <form action="login.php" method="post">
            <label>CPF</label>
            <input type="text" name="cpf" placeholder="Digite seu CPF" required>

            <label>Senha</label>
            <input type="password" name="senha" placeholder="Digite sua senha" required>

            <input type="submit" value="Entrar">
        </form>
    </div>

</body>
</html>
