<?php
session_start();

require_once 'conexao.php';

// =====================================================
// PROCESSAR O PEDIDO SOMENTE QUANDO RECEBER POST
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verificar o token para evitar reenvio do formulário
    $tokenRecebido = $_POST['token_pedido'] ?? '';
    $tokenSessao = $_SESSION['token_pedido'] ?? '';

    if (
        $tokenRecebido === '' ||
        $tokenSessao === '' ||
        !hash_equals($tokenSessao, $tokenRecebido)
    ) {
        exit('Este pedido já foi enviado ou o formulário expirou. ' .
            'Volte à página de pedidos para iniciar outro.');
    }

    // =================================================
    // DADOS DO CLIENTE E DO PEDIDO
    // =================================================

    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    $carrinho = $_POST['carrinho_lista'] ?? '';

    $rua = trim($_POST['rua'] ?? '');
    $numero = trim($_POST['numero'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');

    $obs_entrega = trim($_POST['obs_entrega'] ?? '');

    $forma_pagamento = trim($_POST['form_pag'] ?? '');
    $obs_pagamento = trim($_POST['obs_pagamento'] ?? '');

    $tipo_entrega = $_POST['tipo_entrega'] ?? 'retirada';

    if ($nome === '' || $telefone === '' || $carrinho === '') {
        exit('Preencha os dados do cliente e adicione produtos ao pedido.');
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
    // TOTAL E TAXA DE ENTREGA
    // =================================================

    $total = (float) ($_POST['total'] ?? 0);

    if ($total < 0) {
        exit('O valor do pedido é inválido.');
    }

    if ($tipo_entrega === 'entregar') {
        $total += 6.00;
    }

    // =================================================
    // CADASTRAR OU LOCALIZAR O CLIENTE
    // =================================================

    $sqlBusca = "
        SELECT Id_cliente
        FROM clientes
        WHERE telefone = ?
        LIMIT 1
    ";

    $stmtBusca = mysqli_prepare($conexao, $sqlBusca);

    if (!$stmtBusca) {
        exit('Erro ao preparar a busca do cliente.');
    }

    mysqli_stmt_bind_param($stmtBusca, 's', $telefone);
    mysqli_stmt_execute($stmtBusca);

    $resultado = mysqli_stmt_get_result($stmtBusca);
    $cliente = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($stmtBusca);

    if ($cliente) {

        $id_cliente = (int) $cliente['Id_cliente'];
    } else {

        $sqlCliente = "
            INSERT INTO clientes (nome, telefone)
            VALUES (?, ?)
        ";

        $stmtCliente = mysqli_prepare($conexao, $sqlCliente);

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
    // CADASTRAR OU LOCALIZAR O ENDEREÇO
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
    // CADASTRAR A VENDA UMA ÚNICA VEZ
    // =================================================

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

    // Este ID é obtido depois do INSERT INTO vendas
    $id_venda = mysqli_insert_id($conexao);

    mysqli_stmt_close($stmtVenda);

    // =================================================
    // GUARDAR OS DADOS PARA EXIBIR A COMANDA
    // =================================================

    $_SESSION['comandas'][$id_venda] = [
        'nome' => $nome,
        'telefone' => $telefone,
        'carrinho' => $carrinho,
        'rua' => $rua,
        'numero' => $numero,
        'bairro' => $bairro,
        'obs_entrega' => $obs_entrega,
        'forma_pagamento' => $forma_pagamento,
        'obs_pagamento' => $obs_pagamento,
        'tipo_entrega' => $tipo_entrega,
        'total' => $total
    ];

    // Invalidar o token usado nesse pedido
    unset($_SESSION['token_pedido']);

    // =================================================
    // REDIRECIONAR PARA GET
    // =================================================

    header(
        'Location: imprimir_comanda.php?id=' .
            urlencode((string) $id_venda)
    );

    exit;
}

// =====================================================
// EXIBIR A COMANDA EM UMA REQUISIÇÃO GET
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
    exit('Comanda não encontrada nesta sessão. ' .
        'Não foi realizado um novo cadastro.');
}

$comanda = $_SESSION['comandas'][$id_venda];

$nome = $comanda['nome'];
$telefone = $comanda['telefone'];
$carrinho = $comanda['carrinho'];

$rua = $comanda['rua'];
$numero = $comanda['numero'];
$bairro = $comanda['bairro'];

$obs_entrega = $comanda['obs_entrega'];
$forma_pagamento = $comanda['forma_pagamento'];
$obs_pagamento = $comanda['obs_pagamento'];

$tipo_entrega = $comanda['tipo_entrega'];
$total = $comanda['total'];

// Converter as quebras de linha do carrinho em texto seguro
$carrinhoTexto = preg_replace(
    '/<br\s*\/?>/i',
    "\n",
    $carrinho
);

$carrinhoTexto = htmlspecialchars(
    strip_tags($carrinhoTexto),
    ENT_QUOTES,
    'UTF-8'
);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Comanda - Pedido <?= (int) $id_venda ?>
    </title>

    <link rel="stylesheet" href="style.css">

    <style>
        #comanda {
            width: 350px;
            max-width: 95%;
            margin: 20px auto;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        #comanda table {
            width: 100%;
            border-collapse: collapse;
        }

        #comanda td {
            padding: 5px;
            vertical-align: top;
        }

        .botoes {
            text-align: center;
            margin: 20px;
        }

        .botoes button {
            padding: 10px 18px;
            cursor: pointer;
        }

        .pedido-texto {
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

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
                max-width: none;
                margin: 0;
            }

            .botoes {
                display: none;
            }

            @page {
                margin: 5mm;
            }
        }
    </style>
</head>

<body>

    <div id="comanda">

        <h2 style="text-align: center;">
            COMANDA DO PEDIDO
        </h2>

        <table>

            <tr>
                <td><strong>Pedido Nº:</strong></td>
                <td><?= (int) $id_venda ?></td>
            </tr>

            <tr>
                <td colspan="2">
                    <strong>Nome:</strong><br>
                    <?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <strong>Telefone:</strong><br>
                    <?= htmlspecialchars($telefone, ENT_QUOTES, 'UTF-8') ?>
                </td>
            </tr>

            <tr>
                <td><strong>Tipo:</strong></td>
                <td>
                    <?= $tipo_entrega === 'entregar'
                        ? 'Entrega'
                        : 'Retirada' ?>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <strong>Pedido:</strong>
                    <div class="pedido-texto"><?= $carrinhoTexto ?></div>
                </td>
            </tr>

            <?php if ($obs_pagamento !== ''): ?>
                <tr>
                    <td colspan="2">
                        <strong>Observação do pedido:</strong><br>
                        <?= htmlspecialchars(
                            $obs_pagamento,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if ($tipo_entrega === 'entregar'): ?>

                <tr>
                    <td colspan="2">
                        <strong>Endereço:</strong><br>

                        <?= htmlspecialchars(
                            $rua,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>,
                        <?= htmlspecialchars(
                            $numero,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?><br>

                        Bairro:
                        <?= htmlspecialchars(
                            $bairro,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>
                </tr>

                <?php if ($obs_entrega !== ''): ?>
                    <tr>
                        <td colspan="2">
                            <strong>Observação da entrega:</strong><br>

                            <?= htmlspecialchars(
                                $obs_entrega,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>
                    </tr>
                <?php endif; ?>

            <?php endif; ?>

            <tr>
                <td><strong>Taxa de entrega:</strong></td>
                <td>
                    <?= $tipo_entrega === 'entregar'
                        ? 'R$ 6,00'
                        : 'R$ 0,00' ?>
                </td>
            </tr>

            <tr>
                <td><strong>Total:</strong></td>
                <td>
                    <strong>
                        R$ <?= number_format($total, 2, ',', '.') ?>
                    </strong>
                </td>
            </tr>

            <tr>
                <td><strong>Pagamento:</strong></td>
                <td>
                    <?= htmlspecialchars(
                        $forma_pagamento,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>
            </tr>

        </table>

    </div>

    <div class="botoes">
        <button type="button" onclick="window.print()">
            Imprimir comanda
        </button>
    </div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>

</body>

</html>