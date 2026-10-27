<?php

session_start();
require_once 'conexao.php';

// =====================================================
// RECEBER O ID DO PEDIDO
// =====================================================

$id_venda = filter_input(
    INPUT_POST,
    'id_imprimir',
    FILTER_VALIDATE_INT
);

if (!$id_venda) {
    exit('ID do pedido inválido.');
}

// =====================================================
// BUSCAR OS DADOS DO PEDIDO E DO CLIENTE
// =====================================================

$sql = "
    SELECT
        v.id_venda,
        v.total,
        v.forma_pagamento,
        v.obs_pagamento,
        v.tipo_entrega,
        v.data,
        c.nome,
        c.telefone,
        e.rua,
        e.numero,
        e.bairro
    FROM vendas v

    INNER JOIN clientes c
        ON c.id_cliente = v.id_cliente

    LEFT JOIN enderecos_cliente e
        ON e.id_endereco_cliente = v.id_endereco_cliente

    WHERE v.id_venda = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conexao, $sql);

if (!$stmt) {
    exit('Erro ao preparar a consulta do pedido.');
}

mysqli_stmt_bind_param($stmt, 'i', $id_venda);

if (!mysqli_stmt_execute($stmt)) {
    exit('Erro ao consultar o pedido.');
}

$resultado = mysqli_stmt_get_result($stmt);
$pedido = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);

if (!$pedido) {
    exit('Pedido não encontrado.');
}

// =====================================================
// BUSCAR OS PRODUTOS DO PEDIDO
// =====================================================

$sql_itens = "
    SELECT
        p.nome,
        iv.quantidade,
        iv.valor_unitario,
        iv.subtotal
    FROM itens_venda iv

    INNER JOIN produtos p
        ON p.id_produto = iv.id_produto

    WHERE iv.id_venda = ?
    ORDER BY p.nome
";

$stmt_itens = mysqli_prepare($conexao, $sql_itens);

if (!$stmt_itens) {
    exit('Erro ao preparar a consulta dos produtos.');
}

mysqli_stmt_bind_param($stmt_itens, 'i', $id_venda);

if (!mysqli_stmt_execute($stmt_itens)) {
    exit('Erro ao consultar os produtos do pedido.');
}

$resultado_itens = mysqli_stmt_get_result($stmt_itens);

$itens = [];

while ($item = mysqli_fetch_assoc($resultado_itens)) {
    $itens[] = $item;
}

mysqli_stmt_close($stmt_itens);

// =====================================================
// FORMATAR OS DADOS
// =====================================================

function escapar($valor)
{
    return htmlspecialchars(
        (string) ($valor ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}

$nome = $pedido['nome'];
$telefone = $pedido['telefone'];
$total = (float) $pedido['total'];

$forma_pagamento = $pedido['forma_pagamento'];
$tipo_entrega = $pedido['tipo_entrega'];

$data = $pedido['data'] ?? '';

$rua = $pedido['rua'] ?? '';
$numero = $pedido['numero'] ?? '';
$bairro = $pedido['bairro'] ?? '';

$obs_pagamento = $pedido['obs_pagamento'] ?? '';

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
        Comanda - Pedido <?= (int) $id_venda ?>
    </title>

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
            margin-bottom: 5px;
        }

        .separador {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .campo {
            margin: 8px 0;
            overflow-wrap: anywhere;
        }

        .campo strong {
            display: inline-block;
            margin-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 6px 3px;
            text-align: left;
            border-bottom: 1px solid #ccc;
            font-size: 12px;
        }

        th {
            border-bottom: 1px solid #000;
        }

        .numero,
        .valor {
            text-align: right;
            white-space: nowrap;
        }

        .total {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            text-align: right;
            font-size: 19px;
            font-weight: bold;
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

    <div style="text-align: center;">
        Pedido Nº <?= (int) $pedido['id_venda'] ?>
    </div>

    <div class="separador"></div>

    <!-- CLIENTE -->

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

    <?php endif; ?>

    <div class="separador"></div>

    <!-- PRODUTOS -->

    <strong>PRODUTOS DO PEDIDO</strong>

    <?php if (count($itens) > 0): ?>

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

                        <td>
                            <?= escapar($item['nome']) ?>
                        </td>

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

    <!-- TOTAL -->

    <div class="total">
        TOTAL: R$ <?= number_format($total, 2, ',', '.') ?>
    </div>

    <div class="separador"></div>

    <p style="text-align: center;">
        Obrigado pela preferência!
    </p>

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