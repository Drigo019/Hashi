<?php

require 'conexao.php';

if (!isset($_POST['id_venda']) || !isset($_POST['status'])) {
    exit('erro');
}

$id_venda = intval($_POST['id_venda']);
$status = $_POST['status'];

$status_permitidos = [
    'criado',
    'aceito',
    'preparando',
    'pronto',
    'saiu_para_entrega',
    'entregue'
];

if (!in_array($status, $status_permitidos)) {
    exit('status_invalido');
}

$sql = "UPDATE vendas SET status = ? WHERE id_venda = ?";

$stmt = mysqli_prepare($conexao, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "si",
    $status,
    $id_venda
);

if (mysqli_stmt_execute($stmt)) {
    echo 'ok';
} else {
    echo 'erro';
}

mysqli_stmt_close($stmt);