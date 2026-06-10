<?php
include("conexao.php");

// 1. Recebe e limpa os dados enviados via POST
$cpf   = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$nome  = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : ''; // Não usamos trim na senha para permitir espaços caso o usuário queira

// Função para validar o CPF no Backend de forma oficial
function validarCPF($cpf) {
    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
     
    // Verifica se possui 11 dígitos ou se são números repetidos
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Cálculo matemático dos dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

// 2. Validações de Campos Vazios
if ($nome == '') {
    header("Location: cadastrarUsuario.php?erro=" . urlencode("O nome é obrigatório."));
    exit;
}

if ($cpf == '') {
    header("Location: cadastrarUsuario.php?erro=" . urlencode("O CPF é obrigatório."));
    exit;
}

if ($senha == '') {
    header("Location: cadastrarUsuario.php?erro=" . urlencode("A senha é obrigatória."));
    exit;
}

// 3. Validação Real do CPF
if (!validarCPF($cpf)) {
    header("Location: cadastrarUsuario.php?erro=" . urlencode("Por favor, informe um CPF válido."));
    exit;
}

// 4. Validação Complexa da Senha (Mínimo 6 chars, 1 Maiúscula, 1 Minúscula, 1 Número, 1 Especial)
// Expressão regular idêntica à utilizada no JavaScript
$regexSenha = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/';
if (!preg_match($regexSenha, $senha)) {
    header("Location: cadastrarUsuario.php?erro=" . urlencode("A senha deve ter no mínimo 6 caracteres, com pelo menos: 1 maiúscula, 1 minúscula, 1 número e 1 caractere especial."));
    exit;
}

// Limpa a máscara do CPF antes de salvar no banco para manter o padrão numérico (opcional, mas recomendado)
$cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);

// 5. Preparação e Execução do Banco de Dados
// Mantida a tabela 'usuário' com acento conforme o seu código original
$sql = "INSERT INTO usuário (cpf, nome, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Vincula como string (sss)
    $stmt->bind_param("sss", $cpfLimpo, $nome, $senha);
    
    if (!$stmt->execute()) {
        // Trata erro comum de CPF duplicado se a coluna for UNIQUE no banco
        if ($conn->errno == 1062) {
            header("Location: cadastrarUsuario.php?erro=" . urlencode("Este CPF já está cadastrado no sistema."));
        } else {
            header("Location: cadastrarUsuario.php?erro=" . urlencode("Erro ao inserir o usuário no banco de dados."));
        }
        exit;
    }
    
    // Sucesso! Retorna para a página de listagem/cadastro limpa
    header("Location: cadastrarUsuario.php");
    exit;
} else {
    header("Location: cadastrarUsuario.php?erro=" . urlencode("Erro na preparação da consulta SQL: " . $conn->error));
    exit;
}
?>