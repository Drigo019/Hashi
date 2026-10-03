<?php

    require 'conexao.php';

    $periodo = $_GET['periodo'] ?? 'hoje';
    switch ($periodo) {
        case 'ontem':
            $sql_total = "
                SELECT SUM(total) AS total_periodo
                FROM vendas
                WHERE DATE(data) = CURDATE() - INTERVAL 1 DAY
            ";
            break;
        case 'semana':
            $sql_total = "
                SELECT SUM(total) AS total_periodo
                FROM vendas
                WHERE YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1)
            ";
            break;
        case 'mes':
            $sql_total = "
                SELECT SUM(total) AS total_periodo
                FROM vendas
                WHERE YEAR(data) = YEAR(CURDATE())
                AND MONTH(data) = MONTH(CURDATE())
            ";
            break;
        case 'hoje':
        default:
            $sql_total = "
                SELECT SUM(total) AS total_periodo
                FROM vendas
                WHERE DATE(data) = CURDATE()
            ";
            break;
    }
    $resultado_total = mysqli_query($conexao, $sql_total);
    if (!$resultado_total) {
        die("Erro ao calcular total: " . mysqli_error($conexao));
    }
    $dados_total = mysqli_fetch_assoc($resultado_total);
    $total_periodo = $dados_total['total_periodo'] ?? 0;
    // =====================================================
    // TOTAL POR FORMA DE PAGAMENTO
    // =====================================================

    $sql_pagamentos = "
        SELECT 
            forma_pagamento,
            SUM(total) AS total
        FROM vendas
        WHERE DATE(data) = CURDATE()
        AND status = 'entregue'
        GROUP BY forma_pagamento
    ";

    $resultado_pagamentos = mysqli_query($conexao, $sql_pagamentos);

    if (!$resultado_pagamentos) {
        die("Erro ao calcular pagamentos: " . mysqli_error($conexao));
    }

    $pagamentos = [
        'dinheiro' => 0,
        'cartão' => 0,
        'pix' => 0,
        'ifood' => 0,
        'fiado' => 0
    ];

    while ($linha_pagamento = mysqli_fetch_assoc($resultado_pagamentos)) {

        $forma = $linha_pagamento['forma_pagamento'];
        $valor = $linha_pagamento['total'];

        if (isset($pagamentos[$forma])) {
            $pagamentos[$forma] = $valor;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <!-- Importa a biblioteca Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="body">
    <div style="display: flex;">
        <div style="display: flex;">
            <div id="menu">
                <div id="inicio" align="center" >
                    <button class="btn" onclick="window.location.href='inicio.php'">
                        <img class="icons_menu" src="icons/casa.png">
                        <div style="font-size: 18px;">Início</div>
                    </button>
                </div>
                <div id="novo_pedido" align="center">
                    <button class="btn" onclick="window.location.href='novo_pedido.php'">
                        <img class="icons_menu" src="icons/carrinho_adicionar.png">
                        <div style="font-size: 18px;">Novo Pedido</div>
                    </button>
                </div>
                <div id="" align="center">
                    <button class="btn" onclick="window.location.href='ver_pedidos.php'">
                        <img class="icons_menu" src="icons/pedido.png">
                        <div style="font-size: 18px;">Ver Pedidos</div>
                    </button>
                </div>
                <div id="" align="center">
                    <button class="btn" onclick="window.location.href='produtos.php'">
                        <img class="icons_menu" src="icons/prato.png">
                        <div style="font-size: 18px;">Pratos</div>
                    </button>
                </div>
                <div id="" align="center">
                    <button class="btn" onclick="window.location.href=''">
                        <img class="icons_menu" src="icons/">
                        <div style="font-size: 18px;">Cadastrar Fornecedor</div>
                    </button>
                </div>
            </div>
            <div>
                <button id="btn_menu" onclick="alternarDiv()">
                    <img id="ico_menu" src="icons/seta_direita.png" align="right">
                </button>
            </div>
        </div>
        <div style="display: grid;">
        <!-- ==========================
            ÁREA DE PESQUISA
        =========================== -->
        <div class="area_filtros" style="width: 84vw; height: 10vh; margin-top: -20px;">
            <div style=" display: flex; border: 1px solid; height: 100%; margin-top: 20px;">
                <div id="botoes" align="right" style="width: 100%; margin-top: 15px; margin-right: 20px;">
                    <div id="botoes_data">
                        <button type="button" onclick="abrirPopup()">
                            Fechamento
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- =====================================================
                        POPUPs
===================================================== -->
<!-- =====================================================
    Popup Fechameto
===================================================== -->
<div id="fechamento" class="modal_fundo">
    <div class="modal">
        <button type="button" class="btn_fechar" onclick="fecharPopuplogin()">
            ×
        </button>
        <table id="tabela_fechamento" align="center">
            <tr>
                <th>
                    Dinheiro:
                </th>
                <th>
                    Cartão:
                </th>
            </tr>
            <tr>
                <td>
                    R$ <?php echo number_format($pagamentos['dinheiro'], 2, ',', '.'); ?>
                </td>
                <td>
                    R$ <?php echo number_format($pagamentos['cartão'], 2, ',', '.'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    Pix:
                </th>
                <th>
                    IFood:
                </th>
            </tr>
            <tr>
                <td>
                    R$ <?php echo number_format($pagamentos['pix'], 2, ',', '.'); ?>
                </td>
                <td>
                    R$ <?php echo number_format($pagamentos['ifood'], 2, ',', '.'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    Fiado:
                </th>
                <th>
                    Total:
                </th>
            </tr>
            <tr>
                <td>
                    R$ <?php echo number_format($pagamentos['fiado'], 2, ',', '.'); ?>
                </td>
                <td>
                    R$ <?php echo number_format($total_periodo, 2, ',', '.'); ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">
                    <button type="button" class="btn_imprimir" onclick="imprimirFechamento()">
                        Imprimir
                    </button>
                </th>
            </tr>
        </table>
    </div>
</div>
    <script src="script.js"></script>
</body>
</html>
<script>
    // =====================================================
    // Popup
    // =====================================================
    function abrirPopup() {
            document.getElementById("fechamento").style.display = "flex";
        }
    function fecharPopuplogin() {
        document.getElementById("fechamento").style.display = "none";
    }
    // Fechar clicando no fundo escuro
    document.getElementById("fechamento").addEventListener("click", function(event) {
        if (event.target === this) {
            fecharPopup();
        }
    });


    function imprimirFechamento() {
        window.print();
    }
</script>