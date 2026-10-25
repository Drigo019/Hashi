<?php

require_once 'conexao.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['id_venda']) || !ctype_digit($_GET['id_venda'])) {
    echo json_encode([
        'erro' => 'Número do pedido inválido.'
    ]);
    exit;
}

$id_venda = (int) $_GET['id_venda'];

$sql = "
    SELECT
        p.nome,
        iv.quantidade,
        iv.valor_unitario,
        iv.subtotal
    FROM itens_venda iv
    INNER JOIN produtos p
        ON p.id_produto = iv.id_produto
    WHERE iv.id_venda = ?
";

$stmt = mysqli_prepare($conexao, $sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao preparar a consulta.']);
    exit;
}

mysqli_stmt_bind_param($stmt, 'i', $id_venda);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

$itens = [];

while ($item = mysqli_fetch_assoc($resultado)) {
    $itens[] = $item;
}

mysqli_stmt_close($stmt);

echo json_encode(
    $itens,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);