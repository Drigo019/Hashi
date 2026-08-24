<?php

header('Content-Type: application/json; charset=utf-8');

$conn = new mysqli("localhost", "root", "", "hashi");

if ($conn->connect_error) {
    echo json_encode([
        "erro" => "Erro na conexão com o banco"
    ]);
    exit;
}

$telefone = $_GET['telefone'] ?? '';

$telefone = trim($telefone);

if ($telefone === '') {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT
        c.id_cliente,
        c.nome,
        c.telefone,
        e.rua,
        e.numero,
        e.bairro,
        e.obs_endereco
    FROM clientes c
    LEFT JOIN enderecos_cliente e
        ON e.id_cliente = c.id_cliente
    WHERE c.telefone LIKE ?
    ORDER BY c.nome ASC
    LIMIT 10
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "erro" => $conn->error
    ]);
    exit;
}

$busca = $telefone . "%";

$stmt->bind_param("s", $busca);

$stmt->execute();

$resultado = $stmt->get_result();

$clientes = [];

while ($cliente = $resultado->fetch_assoc()) {

    $clientes[] = [
        "id_cliente" => $cliente["id_cliente"],
        "nome" => $cliente["nome"],
        "telefone" => $cliente["telefone"],
        "rua" => $cliente["rua"],
        "numero" => $cliente["numero"],
        "bairro" => $cliente["bairro"],
        "obs_endereco" => $cliente["obs_endereco"]
    ];
}

echo json_encode($clientes, JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();

?>