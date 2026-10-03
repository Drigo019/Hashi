<?php

include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recebe os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $valor = $_POST['valor'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    // Verifica se a categoria foi selecionada
    if (empty($categoria)) {
        echo "<script> alert('Selecione uma categoria!'); window.location.href='cadastrar_produto.html'; </script>";
        exit;
    }
    // SQL para cadastrar
    $sql = "INSERT INTO produtos (nome, valor, categoria, descricao)
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        die("Erro ao preparar SQL: " . mysqli_error($conexao));
    }
    mysqli_stmt_bind_param($stmt, "sdss", $nome, $valor, $categoria, $descricao);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        echo "<script> alert('Prato cadastrado com sucesso!'); window.location.href='produtos.php'; </script>";
    } else {
        echo "<script> alert('Erro ao cadastrar prato: " . mysqli_stmt_error($stmt) . "'); </script>";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conexao);
?>