<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $valor = $_POST['valor'] ?? '';
    $forma_pagamento = $_POST['form_pag'] ?? '';
    $tipo_entrega = $_POST['tipo_entrega'] ?? 'retirada';

    $rua = $_POST['rua'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $bairro = $_POST['bairro'] ?? '';

    // 🔥 SE FOR ENTREGA → salva endereço
    if ($tipo_entrega === "entregar") {
        $sqlEndereco = "INSERT INTO enderecos_clientes (rua, numero, bairro) VALUES (?, ?, ?)";
        $stmtEndereco = mysqli_prepare($conexao, $sqlEndereco);
        mysqli_stmt_bind_param($stmtEndereco, "sis", $rua, $numero, $bairro);
        mysqli_stmt_execute($stmtEndereco);

        $id_endereco_cliente = mysqli_insert_id($conexao);
    } else {
        // 🔥 GARANTE RETIRADA
        $tipo_entrega = "retirada";
        $id_endereco_cliente = null;
    }

    // 🔥 INSERE A VENDA (com ou sem endereço)
    $sql = "INSERT INTO vendas (nome, telefone, valor, forma_pagamento, tipo_entrega, id_endereco_cliente) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssdssi", $nome, $telefone, $valor, $forma_pagamento, $tipo_entrega, $id_endereco_cliente);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('Pedido cadastrado com sucesso!');</script>";
        echo "<script>window.location.href='inicio.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar pedido');</script>";
    }
    
}
?>
