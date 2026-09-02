<?php

include 'conexao.php';

// Recebe os dados do formulário
$nome = $_POST['nome'];
$valor = $_POST['valor'];
$categoria = $_POST['categoria'];
$descricao = $_POST['descricao'];
$fornecedor = $_POST['fornecedor'];

        // Cadastra o produto
        $sql = "INSERT INTO produtos
        (nome, categoria, valor, descricao, id_fornecedor )
        VALUES
        ('$nome', '$valor', '$categoria', '$descricao', '$fornecedor')";

        if ($conn->query($sql)) {
            echo "Produto cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar produto: " . $conn->error;
        }

?>