<?php
require('conexao.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST['id_cancelar'];

    $sql = "DELETE FROM vendas WHERE id_venda = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('location: ver_pedidos.php');
    exit();
}
?>