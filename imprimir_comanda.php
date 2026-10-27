```php
<?php

session_start();

require_once 'conexao.php';

// =====================================================
// PROCESSAR O PEDIDO SOMENTE QUANDO RECEBER POST
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verificar token para evitar pedidos duplicados
    $tokenRecebido = $_POST['token_pedido'] ?? '';
    $tokenSessao = $_SESSION['token_pedido'] ?? '';

    if (
        $tokenRecebido === '' ||
        $tokenSessao === '' ||
        !hash_equals($tokenSessao, $tokenRecebido)
    ) {
        exit(
            'Este pedido já foi enviado ou o formulário expirou. ' .
            'Volte à página de pedidos para iniciar outro.'
        );
    }

    // =================================================
    // RECEBER OS DADOS
    // =================================================

    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    $carrinho = $_POST['carrinho_lista'] ?? '';

    $itensJson = $_POST['itens'] ?? '';
    $itens = json_decode($itensJson, true);

    if (
        !is_array($itens) ||
        empty($itens) ||
        json_last_error() !== JSON_ERROR_NONE
    ) {
        exit('Carrinho inválido ou vazio.');
    }

    $rua = trim($_POST['rua'] ?? '');
    $numero = trim($_POST['numero'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');

    $obs_entrega = trim($_POST['obs_entrega'] ?? '');

    $forma_pagamento = trim($_POST['form_pag'] ?? '');
    $obs_pagamento = trim($_POST['obs_pagamento'] ?? '');

    $tipo_entrega = $_POST['tipo_entrega'] ?? 'retirada';

    if ($nome === '' || $telefone === '' || $carrinho === '') {
        exit(
            'Preencha os dados do cliente e adicione produtos ao pedido.'
        );
    }

    if (!in_array($tipo_entrega, ['retirada', 'entregar'], true)) {
        exit('Tipo de entrega inválido.');
    }

    if (
        $tipo_entrega === 'entregar' &&
        ($rua === '' || $numero === '' || $bairro === '')
    ) {
        exit('Preencha a rua, o número e o bairro para a entrega.');
    }

    // =================================================
    // VALIDAR PRODUTOS E CALCULAR O TOTAL
    // =================================================

    $total = 0.0;
    $itensValidados = [];

    $sqlProduto = "
        SELECT id_produto, nome, valor
        FROM produtos
        WHERE id_produto = ?
        LIMIT 1
    ";

    $stmtProduto = mysqli_prepare($conexao, $sqlProduto);

    if (!$stmtProduto) {
        exit('Erro ao preparar a consulta dos produtos.');
    }

    foreach ($itens as $item) {

        $id_produto = filter_var(
            $item['id_produto'] ?? null,
            FILTER_VALIDATE_INT
        );

        $quantidade = filter_var(
            $item['qtd'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (
            !$id_produto ||
            !$quantidade ||
            $quantidade < 1 ||
            $quantidade > 1000
        ) {
            mysqli_stmt_close($stmtProduto);
            exit('Produto ou quantidade inválidos.');
        }

        mysqli_stmt_bind_param(
            $stmtProduto,
            'i',
            $id_produto
        );

        if (!mysqli_stmt_execute($stmtProduto)) {
            mysqli_stmt_close($stmtProduto);
            exit('Erro ao consultar o produto.');
        }

        $resultadoProduto = mysqli_stmt_get_result($stmtProduto);
        $produto = mysqli_fetch_assoc($resultadoProduto);

        if (!$produto) {
            mysqli_stmt_close($stmtProduto);
            exit('Um dos produtos não foi encontrado.');
        }

        $valorUnitario = (float) $produto['valor'];

        $subtotal = round(
            $valorUnitario * $quantidade,
            2
        );

        $total += $subtotal;

        $itensValidados[] = [
            'id_produto' => (int) $produto['id_produto'],
            'nome' => $produto['nome'],
            'quantidade' => $quantidade,
            'valor_unitario' => $valorUnitario,
            'subtotal' => $subtotal
        ];
    }

    mysqli_stmt_close($stmtProduto);

    // Taxa de entrega
    $taxaEntrega = 0.0;

    if ($tipo_entrega === 'entregar') {
        $taxaEntrega = 6.00;
        $total = round($total + $taxaEntrega, 2);
    }

    // =================================================
    // LOCALIZAR OU CADASTRAR CLIENTE
    // =================================================

    $sqlBusca = "
        SELECT id_cliente
        FROM clientes
        WHERE telefone = ?
        LIMIT 1
    ";

    $stmtBusca = mysqli_prepare($conexao, $sqlBusca);

    if (!$stmtBusca) {
        exit('Erro ao preparar a busca do cliente.');
    }

    mysqli_stmt_bind_param(
        $stmtBusca,
        's',
        $telefone
    );

    mysqli_stmt_execute($stmtBusca);

    $resultado = mysqli_stmt_get_result($stmtBusca);
    $cliente = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($stmtBusca);

    if ($cliente) {

        $id_cliente = (int) $cliente['id_cliente'];

        // Atualizar o nome caso o cliente já exista
        $sqlAtualizaCliente = "
            UPDATE clientes
            SET nome = ?
            WHERE id_cliente = ?
        ";

        $stmtAtualiza = mysqli_prepare(
            $conexao,
            $sqlAtualizaCliente
        );

        if ($stmtAtualiza) {
            mysqli_stmt_bind_param(
                $stmtAtualiza,
                'si',
                $nome,
                $id_cliente
            );

            mysqli_stmt_execute($stmtAtualiza);
            mysqli_stmt_close($stmtAtualiza);
        }

    } else {

        $sqlCliente = "
            INSERT INTO clientes (nome, telefone)
            VALUES (?, ?)
        ";

        $stmtCliente = mysqli_prepare(
            $conexao,
            $sqlCliente
        );

        if (!$stmtCliente) {
            exit('Erro ao preparar o cadastro do cliente.');
        }

        mysqli_stmt_bind_param(
            $stmtCliente,
            'ss',
            $nome,
            $telefone
        );

        if (!mysqli_stmt_execute($stmtCliente)) {
            mysqli_stmt_close($stmtCliente);
            exit('Erro ao cadastrar o cliente.');
        }

        $id_cliente = mysqli_insert_id($conexao);

        mysqli_stmt_close($stmtCliente);
    }

    // =================================================
    // LOCALIZAR OU CADASTRAR ENDEREÇO
    // =================================================

    $id_endereco_cliente = null;

    if ($tipo_entrega === 'entregar') {

        $sqlBuscaEndereco = "
            SELECT id_endereco_cliente
            FROM enderecos_cliente
            WHERE id_cliente = ?
              AND rua = ?
              AND numero = ?
              AND bairro = ?
            LIMIT 1
        ";

        $stmtEndereco = mysqli_prepare(
            $conexao,
            $sqlBuscaEndereco
        );

        if (!$stmtEndereco) {
            exit('Erro ao preparar a busca do endereço.');
        }

        mysqli_stmt_bind_param(
            $stmtEndereco,
            'isss',
            $id_cliente,
            $rua,
            $numero,
            $bairro
        );

        mysqli_stmt_execute($stmtEndereco);

        $resultadoEndereco = mysqli_stmt_get_result(
            $stmtEndereco
        );

        $endereco = mysqli_fetch_assoc($resultadoEndereco);

        mysqli_stmt_close($stmtEndereco);

        if ($endereco) {

            $id_endereco_cliente = (int)
                $endereco['id_endereco_cliente'];

        } else {

            $sqlNovoEndereco = "
                INSERT INTO enderecos_cliente
                    (id_cliente, rua, numero, bairro)
                VALUES (?, ?, ?, ?)
            ";

            $stmtNovoEndereco = mysqli_prepare(
                $conexao,
                $sqlNovoEndereco
            );

            if (!$stmtNovoEndereco) {
                exit('Erro ao preparar o cadastro do endereço.');
            }

            mysqli_stmt_bind_param(
                $stmtNovoEndereco,
                'isss',
                $id_cliente,
                $rua,
                $numero,
                $bairro
            );

            if (!mysqli_stmt_execute($stmtNovoEndereco)) {
                mysqli_stmt_close($stmtNovoEndereco);
                exit('Erro ao cadastrar o endereço.');
            }

            $id_endereco_cliente = mysqli_insert_id($conexao);

            mysqli_stmt_close($stmtNovoEndereco);
        }
    }

    // =================================================
    // CADASTRAR VENDA
    // =====================================================

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

    $stmtVenda = mysqli_prepare($conexao, $sqlVenda);

    if (!$stmtVenda) {
        exit('Erro ao preparar o cadastro da venda.');
    }

    mysqli_stmt_bind_param(
        $stmtVenda,
        'iidsss',
        $id_cliente,
        $id_endereco_cliente,
        $total,
        $forma_pagamento,
        $obs_pagamento,
        $tipo_entrega
    );

    if (!mysqli_stmt_execute($stmtVenda)) {
        mysqli_stmt_close($stmtVenda);
        exit('Erro ao cadastrar a venda.');
    }

    $id_venda = mysqli_insert_id($conexao);

    mysqli_stmt_close($stmtVenda);

    // =================================================
    // CADASTRAR ITENS DA VENDA
    // =================================================

    $sqlItem = "
        INSERT INTO itens_venda
        (
            id_venda,
            id_produto,
            quantidade,
            valor_unitario,
            subtotal
        )
        VALUES (?, ?, ?, ?, ?)
    ";

    $stmtItem = mysqli_prepare($conexao, $sqlItem);

    if (!$stmtItem) {
        exit('Erro ao preparar o cadastro dos itens.');
    }

    foreach ($itensValidados as $item) {

        $id_produto = $item['id_produto'];
        $quantidade = $item['quantidade'];
        $valorUnitario = $item['valor_unitario'];
        $subtotal = $item['subtotal'];

        mysqli_stmt_bind_param(
            $stmtItem,
            'iiidd',
            $id_venda,
            $id_produto,
            $quantidade,
            $valorUnitario,
            $subtotal
        );

        if (!mysqli_stmt_execute($stmtItem)) {
            mysqli_stmt_close($stmtItem);
            exit(
                'Erro ao salvar os produtos do pedido: ' .
                mysqli_error($conexao)
            );
        }
    }

    mysqli_stmt_close($stmtItem);

    // =================================================
    // GUARDAR DADOS DA COMANDA NA SESSÃO
    // =================================================

    $_SESSION['comandas'][$id_venda] = [
        'nome' => $nome,
        'telefone' => $telefone,
        'itens' => $itensValidados,
        'rua' => $rua,
        'numero' => $numero,
        'bairro' => $bairro,
        'obs_entrega' => $obs_entrega,
        'forma_pagamento' => $forma_pagamento,
        'obs_pagamento' => $obs_pagamento,
        'tipo_entrega' => $tipo_entrega,
        'taxa_entrega' => $taxaEntrega,
        'total' => $total,
        'data' => date('Y-m-d H:i:s')
    ];

    // Invalidar token utilizado
    unset($_SESSION['token_pedido']);

    // Redirecionar para exibir a comanda
    header(
        'Location: imprimir_comanda.php?id=' .
        urlencode((string) $id_venda)
    );

    exit;
}

// =====================================================
// EXIBIR COMANDA NO GET
// =====================================================

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit('Método não permitido.');
}

$id_venda = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if (!$id_venda || empty($_SESSION['comandas'][$id_venda])) {
    http_response_code(404);
    exit(
        'Comanda não encontrada nesta sessão. ' .
        'Não foi realizado um novo cadastro.'
    );
}

$comanda = $_SESSION['comandas'][$id_venda];

// Dados da comanda
$nome = $comanda['nome'];
$telefone = $comanda['telefone'];
$itens = $comanda['itens'] ?? [];

$rua = $comanda['rua'];
$numero = $comanda['numero'];
$bairro = $comanda['bairro'];

$obs_entrega = $comanda['obs_entrega'];
$forma_pagamento = $comanda['forma_pagamento'];
$obs_pagamento = $comanda['obs_pagamento'];

$tipo_entrega = $comanda['tipo_entrega'];
$taxaEntrega = (float) ($comanda['taxa_entrega'] ?? 0);
$total = (float) $comanda['total'];
$data = $comanda['data'] ?? '';

function escapar($valor)
{
    return htmlspecialchars(
        (string) ($valor ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Comanda - Pedido <?= (int) $id_venda ?></title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 15px;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            background: #fff;
        }

        #comanda {
            width: 350px;
            max-width: 100%;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            font-size: 20px;
            margin: 0 0 5px;
        }

        .pedido-numero {
            text-align: center;
            font-size: 13px;
        }

        .separador {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .campo {
            margin: 8px 0;
            overflow-wrap: anywhere;
            font-size: 20px;
            line-height: 1.4;
        }

        .campo strong {
            display: inline-block;
            margin-bottom: 3px;
            font-size: 20px;
        }

        .titulo-produtos {
            font-weight: bold;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }

        th,
        td {
            padding: 6px 3px;
            text-align: left;
            border-bottom: 1px solid #ccc;
            font-size: 20px;
            overflow-wrap: anywhere;
        }

        th {
            border-bottom: 1px solid #000;
        }

        th:first-child,
        td:first-child {
            width: 39%;
        }

        .numero {
            width: 12%;
            text-align: right;
            white-space: nowrap;
        }

        .valor {
            width: 24.5%;
            text-align: right;
            white-space: nowrap;
            font-size: 15px;
        }

        .total {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            text-align: right;
            font-size: 19px;
            font-weight: bold;
        }

        .agradecimento {
            text-align: center;
            font-size: 12px;
            margin: 15px 0 5px;
        }

        .botoes {
            text-align: center;
            margin: 20px auto;
        }

        .botoes button {
            padding: 10px 18px;
            margin: 5px;
            cursor: pointer;
        }

        @media print {
            @page {
                size: auto;
                margin: 5mm;
            }

            body {
                padding: 0;
            }

            #comanda {
                width: 100%;
                max-width: 100%;
                margin: 0;
                font-size: 13px
            }

            .botoes {
                display: none;
            }
        }
    </style>
</head>

<body>

<div id="comanda">

    <h2>COMANDA DO PEDIDO</h2>

    <div class="pedido-numero">
        Pedido Nº <?= (int) $id_venda ?>
    </div>

    <div class="separador"></div>

    <!-- DADOS DO CLIENTE -->

    <div class="campo">
        <strong>Nome:</strong><br>
        <?= escapar($nome) ?>
    </div>

    <div class="campo">
        <strong>Telefone:</strong><br>
        <?= escapar($telefone) ?>
    </div>

    <div class="campo">
        <strong>Data:</strong><br>
        <?= $data !== ''
            ? escapar(date('d/m/Y H:i', strtotime($data)))
            : 'Não informada' ?>
    </div>

    <div class="campo">
        <strong>Tipo de recebimento:</strong><br>

        <?= $tipo_entrega === 'entregar'
            ? 'Entrega'
            : 'Retirada' ?>
    </div>

    <!-- ENDEREÇO -->

    <?php if ($tipo_entrega === 'entregar'): ?>

        <div class="campo">
            <strong>Endereço:</strong><br>

            <?= escapar($rua) ?>,
            <?= escapar($numero) ?><br>

            Bairro: <?= escapar($bairro) ?>
        </div>

        <?php if ($obs_entrega !== ''): ?>
            <div class="campo">
                <strong>Observação da entrega:</strong><br>
                <?= nl2br(escapar($obs_entrega)) ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <div class="separador"></div>

    <!-- PRODUTOS -->

    <div class="titulo-produtos">
        PRODUTOS DO PEDIDO
    </div>

    <?php if (!empty($itens)): ?>

        <table>

            <thead>
                <tr>
                    <th>Produto</th>
                    <th class="numero">Qtd.</th>
                    <th class="valor">Unit.</th>
                    <th class="valor">Subtotal</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($itens as $item): ?>

                    <tr>
                        <td><?= escapar($item['nome']) ?></td>

                        <td class="numero">
                            <?= (int) $item['quantidade'] ?>
                        </td>

                        <td class="valor">
                            <?= number_format(
                                (float) $item['valor_unitario'],
                                2,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td class="valor">
                            <?= number_format(
                                (float) $item['subtotal'],
                                2,
                                ',',
                                '.'
                            ) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php else: ?>

        <p>Nenhum produto encontrado neste pedido.</p>

    <?php endif; ?>

    <!-- PAGAMENTO -->

    <div class="separador"></div>

    <div class="campo">
        <strong>Forma de pagamento:</strong><br>
        <?= escapar($forma_pagamento) ?>
    </div>

    <?php if ($obs_pagamento !== ''): ?>

        <div class="campo">
            <strong>Observação do pagamento:</strong><br>
            <?= nl2br(escapar($obs_pagamento)) ?>
        </div>

    <?php endif; ?>

    <!-- TAXA E TOTAL -->

    <div class="campo">
        <strong>Taxa de entrega:</strong>
        R$ <?= number_format($taxaEntrega, 2, ',', '.') ?>
    </div>

    <div class="total">
        TOTAL: R$ <?= number_format($total, 2, ',', '.') ?>
    </div>



</div>

<div class="botoes">

    <button type="button" onclick="window.print()">
        Imprimir comanda
    </button>

    <button
        type="button"
        onclick="window.location.href='ver_pedidos.php'"
    >
        Voltar
    </button>

</div>

<script>
    window.addEventListener('load', function () {
        window.print();
    });
</script>

</body>
</html>
