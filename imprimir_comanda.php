<?php

require('conexao.php');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Acesso inválido.");
}

// =============================
// DADOS DO CLIENTE
// =============================

$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';

$carrinho = $_POST['carrinho_lista'] ?? '';

$rua = trim($_POST['rua'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$bairro = trim($_POST['bairro'] ?? '');

$obs_entrega = $_POST['obs_entrega'] ?? '';

$forma_pagamento = $_POST['form_pag'] ?? '';
$obs_pagamento = $_POST['obs_pagamento'] ?? '';

$tipo_entrega = $_POST['tipo_entrega'] ?? 'retirada';

// =============================
// TOTAL
// =============================

$total = (float)($_POST['total'] ?? 0);

// Garante os R$ 6,00 somente para entrega
if ($tipo_entrega === 'entregar') {
    $total += 6.00;
}

// =============================
// CLIENTE
// =============================

$sqlBusca = "
    SELECT Id_cliente
    FROM clientes
    WHERE telefone = ?
    LIMIT 1
";

$stmtBusca = mysqli_prepare($conexao, $sqlBusca);

if (!$stmtBusca) {
    exit(
        "Erro ao preparar busca do cliente: "
        . mysqli_error($conexao)
    );
}

mysqli_stmt_bind_param(
    $stmtBusca,
    "s",
    $telefone
);

mysqli_stmt_execute($stmtBusca);

$resultado = mysqli_stmt_get_result($stmtBusca);

if ($row = mysqli_fetch_assoc($resultado)) {

    // Cliente já existe
    $id_cliente = $row['Id_cliente'];

} else {

    // =============================
    // CRIA NOVO CLIENTE
    // =============================

    $sql = "
        INSERT INTO clientes
        (
            nome,
            telefone
        )
        VALUES (?, ?)
    ";

    $stmt = mysqli_prepare($conexao, $sql);

    if (!$stmt) {
        exit(
            "Erro ao preparar cadastro do cliente: "
            . mysqli_error($conexao)
        );
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $nome,
        $telefone
    );

    if (!mysqli_stmt_execute($stmt)) {
        exit(
            "Erro ao cadastrar cliente: "
            . mysqli_stmt_error($stmt)
        );
    }

    $id_cliente = mysqli_insert_id($conexao);
}

// =============================
// ENDEREÇO
// =============================

if ($tipo_entrega === "entregar") {

    // ==========================================
    // PROCURA SE O ENDEREÇO JÁ EXISTE
    // PARA ESTE CLIENTE
    // ==========================================

    $sqlBuscaEndereco = "
        SELECT id_endereco_cliente
        FROM enderecos_cliente
        WHERE id_cliente = ?
          AND rua = ?
          AND numero = ?
          AND bairro = ?
        LIMIT 1
    ";

    $stmtBuscaEndereco = mysqli_prepare(
        $conexao,
        $sqlBuscaEndereco
    );

    if (!$stmtBuscaEndereco) {
        exit(
            "Erro ao preparar busca do endereço: "
            . mysqli_error($conexao)
        );
    }

    mysqli_stmt_bind_param(
        $stmtBuscaEndereco,
        "isss",
        $id_cliente,
        $rua,
        $numero,
        $bairro
    );

    mysqli_stmt_execute($stmtBuscaEndereco);

    $resultadoEndereco = mysqli_stmt_get_result(
        $stmtBuscaEndereco
    );

    // ==========================================
    // ENDEREÇO JÁ EXISTE
    // ==========================================

    if ($linhaEndereco = mysqli_fetch_assoc($resultadoEndereco)) {

        // Usa o endereço que já está cadastrado
        $id_endereco_cliente =
            $linhaEndereco['id_endereco_cliente'];

    } else {

        // ==========================================
        // ENDEREÇO NÃO EXISTE
        // ENTÃO CADASTRA
        // ==========================================

        $sqlEndereco = "
            INSERT INTO enderecos_cliente
            (
                id_cliente,
                rua,
                numero,
                bairro
            )
            VALUES (?, ?, ?, ?)
        ";

        $stmtEndereco = mysqli_prepare(
            $conexao,
            $sqlEndereco
        );

        if (!$stmtEndereco) {
            exit(
                "Erro ao preparar endereço: "
                . mysqli_error($conexao)
            );
        }

        mysqli_stmt_bind_param(
            $stmtEndereco,
            "isss",
            $id_cliente,
            $rua,
            $numero,
            $bairro
        );

        if (!mysqli_stmt_execute($stmtEndereco)) {
            exit(
                "Erro ao cadastrar endereço: "
                . mysqli_stmt_error($stmtEndereco)
            );
        }

        // Pega o ID do endereço recém-criado
        $id_endereco_cliente = mysqli_insert_id($conexao);
    }

} else {

    // =============================
    // RETIRADA
    // =============================

    $tipo_entrega = "retirada";

    $id_endereco_cliente = null;
}

// =============================
// INSERE VENDA
// =============================

$sqlVenda = "
    INSERT INTO vendas
    (
        id_cliente,
        id_endereco_cliente,
        total,
        forma_pagamento,
        obs_pagamento,
        tipo_entrega
    )
    VALUES (?, ?, ?, ?, ?, ?)
";

$stmtVenda = mysqli_prepare(
    $conexao,
    $sqlVenda
);

if (!$stmtVenda) {
    exit(
        "Erro ao preparar venda: "
        . mysqli_error($conexao)
    );
}

mysqli_stmt_bind_param(
    $stmtVenda,
    "iidsss",
    $id_cliente,
    $id_endereco_cliente,
    $total,
    $forma_pagamento,
    $obs_pagamento,
    $tipo_entrega
);

if (!mysqli_stmt_execute($stmtVenda)) {
    exit(
        "Erro ao cadastrar venda: "
        . mysqli_stmt_error($stmtVenda)
    );
}

// =============================
// PEGA O ID DA VENDA
// =============================

$id_venda = mysqli_insert_id($conexao);

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Comanda - Pedido <?php echo htmlspecialchars($id_venda); ?>
    </title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>

<body>

<div id="comanda">

    <table style="height: auto; margin: 20px; margin-top: 0;">

        <!-- =============================
             ID DA VENDA
        ============================== -->

        <tr>

            <td>
                <strong>Pedido Nº:</strong>
            </td>

            <td>
                <?php echo htmlspecialchars($id_venda); ?>
            </td>

        </tr>


        <!-- =============================
             CLIENTE
        ============================== -->

        <tr>

            <td>
                <strong>Nome:</strong>
            </td>

        </tr>

        <tr>

            <td colspan="2">

                <?php echo htmlspecialchars($nome); ?>

            </td>

        </tr>


        <tr>

            <td>
                <strong>Telefone:</strong>
            </td>

        </tr>

        <tr>

            <td colspan="2">

                <?php echo htmlspecialchars($telefone); ?>

            </td>

        </tr>


        <!-- =============================
             TIPO DE PEDIDO
        ============================== -->

        <tr>

            <td>
                <strong>Tipo:</strong>
            </td>

            <td>

                <?php

                echo ($tipo_entrega === 'entregar')
                    ? 'Entrega'
                    : 'Retirada';

                ?>

            </td>

        </tr>


        <!-- =============================
             PEDIDO
        ============================== -->

        <tr>

            <td colspan="2">

                <strong>Pedido:</strong>

            </td>

        </tr>

        <tr>

            <td colspan="2">

                <?php echo $carrinho; ?>

            </td>

        </tr>


        <tr>

            <td colspan="2">

                <strong>Observação do pedido:</strong>

            </td>

        </tr>

        <tr>

            <td
                colspan="2"
                style="border: 7px solid;"
            >

                <?php echo htmlspecialchars($obs_pagamento); ?>

            </td>

        </tr>


        <!-- =============================
             ENDEREÇO
        ============================== -->

        <?php if ($tipo_entrega === 'entregar'): ?>

            <tr>

                <td>

                    <strong>Rua:</strong>

                </td>

            </tr>

            <tr>

                <td colspan="2">

                    <?php echo htmlspecialchars($rua); ?>

                </td>

            </tr>


            <tr>

                <td>

                    <strong>Número:</strong>

                </td>

                <td>

                    <?php echo htmlspecialchars($numero); ?>

                </td>

            </tr>


            <tr>

                <td>

                    <strong>Bairro:</strong>

                </td>

            </tr>

            <tr>

                <td colspan="2">

                    <?php echo htmlspecialchars($bairro); ?>

                </td>

            </tr>


            <tr>

                <td colspan="2">

                    <strong>Observação de Entrega:</strong>

                </td>

            </tr>

            <tr>

                <td colspan="2">

                    <?php echo htmlspecialchars($obs_entrega); ?>

                </td>

            </tr>

        <?php endif; ?>


        <!-- =============================
             TAXA DE ENTREGA
        ============================== -->

        <tr>

            <td>

                <strong>Taxa de entrega:</strong>

            </td>

            <td>

                <?php

                echo ($tipo_entrega === 'entregar')
                    ? 'R$ 6,00'
                    : 'R$ 0,00';

                ?>

            </td>

        </tr>


        <!-- =============================
             TOTAL
        ============================== -->

        <tr>

            <td>

                <strong>Total:</strong>

            </td>

            <td>

                R$

                <?php

                echo number_format(
                    $total,
                    2,
                    ',',
                    '.'
                );

                ?>

            </td>

        </tr>


        <!-- =============================
             PAGAMENTO
        ============================== -->

        <tr>

            <td>

                <strong>Forma de Pagamento:</strong>

            </td>

            <td>

                <?php

                echo htmlspecialchars(
                    $forma_pagamento
                );

                ?>

            </td>

        </tr>

    </table>

</div>


<script>

window.onload = function() {

    window.print();

};

</script>


<style>

@media print {

    body * {

        visibility: hidden;

    }

    #comanda,
    #comanda * {

        visibility: visible;

    }

    #comanda {

        position: absolute;

        top: 0;

        left: 0;

        width: 100%;

    }

    @page {

        margin: 0;

    }

    body {

        margin: 0;

        padding: 0;

    }

}

</style>

</body>

</html>