<?php
include("conexao.php"); // Conexão com o banco de dados

// Coleta de dados do formulário
$nivel_usuario = $_POST['nivel_usuario'];
$nome_usuario = $_POST['nome_usuario'];
$sobrenome = $_POST['sobrenome'];
$funcao = $_POST['funcao'];
$logi = $_POST['logi'];
$senha = $_POST['senha'];

// Criptografar a senha antes de armazenar no banco de dados
$senha_criptografada = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha

// Verifica se o login (logi) já existe
$check_logi_sql = "SELECT logi FROM usuario WHERE logi = ?";
$stmt = mysqli_prepare($conexao, $check_logi_sql);
mysqli_stmt_bind_param($stmt, "s", $logi); // "s" para string
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (!$resultado) {
    echo "Erro ao verificar o login: " . mysqli_error($conexao);
    exit;
}

if (mysqli_num_rows($resultado) > 0) {
    // Se o login já existir, retorne erro
    echo "Erro: Este login já está cadastrado.";
} else {
    // Caso o login seja novo, prossiga com o cadastro

    // Preparar a SQL para inserir o usuário no banco de dados
    $sql = "INSERT INTO usuario (nivel_usuario, nome_usuario, sobrenome, funcao, logi, senha) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    
    // Executar a inserção e verificar se foi bem-sucedida
    mysqli_stmt_bind_param($stmt, "ssssss", $nivel_usuario, $nome_usuario, $sobrenome, $funcao, $logi, $senha_criptografada);
    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado) {
        echo "Usuário cadastrado com sucesso.";
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}

// Fecha a conexão
mysqli_close($conexao);
?>
