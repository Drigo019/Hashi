<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];}

    $sql = "INSERT INTO produtos (nome, valor, categoria, descricao) 
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssdssi", $nome, $valor, $categoria, $descricao);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('Pedido cadastrado com sucesso!');</script>";
        echo "<script>window.location.href='inicio.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar pedido');</script>";
    }