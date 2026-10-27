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
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pedidos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">
    <div style="display: flex;">
        <div style="display: flex;">
            <!-- ==========================
                MENU
            =========================== -->
            <div id="menu">
                <div id="inicio" align="center">
                    <button class="btn" onclick="window.location.href='inicio.php'">
                        <img class="icons_menu" src="icons/casa.png">
                        <div style="font-size: 18px;">
                            Início
                        </div>
                    </button>
                </div>
                <div id="novo_pedido" align="center">
                    <button class="btn" onclick="window.location.href='novo_pedido.php'">
                        <img class="icons_menu" src="icons/carrinho_adicionar.png">
                        <div style="font-size: 18px;">
                            Novo Pedido
                        </div>
                    </button>
                </div>
                <div align="center">
                    <button class="btn" onclick="window.location.href='ver_pedidos.php'">
                        <img class="icons_menu" src="icons/pedido.png">
                        <div style="font-size: 18px;">
                            Ver Pedidos
                        </div>
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
            <!-- BOTÃO DO MENU -->
            <div>
                <button id="btn_menu" onclick="alternarDiv()">
                    <img id="ico_menu" src="icons/seta_direita.png">
                </button>
            </div>
            <!-- ==========================
                CONTEÚDO
            =========================== -->
            <div style="display: grid;">
                <!-- ==========================
                    ÁREA DE PESQUISA
                =========================== -->
                <div class="area_filtros" style=" border: 1px solid; width: 98vw; height: 20vh; ">
                    <div style=" display: flex; height: 100%; margin-top: 20px; ">
                        <!-- PESQUISA -->
                        <div style="width: 30%;" align="center">
                            <input type="text" name="barra_pesquisa_pedidos" id="barra_pesquisa_pedidos">
                            <button id="btn_pesquisa_pedidos" onclick="pesquisarPedidos()">
                                🔍
                            </button>
                        </div>
                        <!-- BOTÕES -->
                        <div id="botoes" align="center" style="width: 30%; margin-top: 2%;">
                            <div id="botoes_data">
                                <input type="button" value="Ontem" id="ontem" onclick="alterarPeriodo('ontem')">
                                <input type="button" value="Hoje" id="hoje" onclick="alterarPeriodo('hoje')">
                                <button type="button" onclick="abrirPopup()">
                                    Fechamento
                                </button>
                            </div>
                        </div>
                        <?php
                        $sql_total = "
                                SELECT SUM(total) AS total_dia
                                FROM vendas
                                WHERE DATE(data) = CURDATE() and status = 'entregue'";
                        $resultado_total = mysqli_query($conexao, $sql_total);
                        $dados_total = mysqli_fetch_assoc($resultado_total);
                        $total_dia = $dados_total['total_dia'] ?? 0;
                        ?>
                        <div style="width: 27%">
                            <div style="display: grid; height: 100%; width: 100%; " align="center">
                                <label style="margin-top: 10px; margin-bottom: -100px; font-size: 30px; height: 30px;">Total:</label>
                                <div style="font-size: 25px;" id="Total_dia">
                                    R$ <?php echo number_format($total_periodo, 2, ',', '.'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ==========================
                    TABELA
                =========================== -->
                <div style=" border: 1px solid; width: 98vw; height: 80vh; ">
                    <div id="area_tabela">
                        <table border="1" id="table_clientes">
                            <!-- CABEÇALHO -->
                            <tr class="tr">
                                <th class="th_titulo">
                                    ID
                                </th>
                                <th class="th_titulo">
                                    Nome
                                </th>
                                <th class="th_titulo">
                                    Telefone
                                </th>
                                <th class="th_titulo">
                                    Valor
                                </th>
                                <th class="th_titulo">
                                    Forma de pagamento
                                </th>
                                <th class="th_titulo">
                                    Data
                                </th>
                                <th class="th_titulo">
                                    Tipo de recebimento
                                </th>
                                <th class="th_titulo">
                                    Status
                                </th>
                                <th class="th_titulo" colspan="3">
                                    Funções
                                </th>
                            </tr>
                            <?php
                            $sql = "
                                SELECT v.id_venda, c.nome, c.telefone, v.total, v.forma_pagamento, v.tipo_entrega, v.data, v.status
                                FROM vendas v
                                JOIN clientes c
                                ON c.id_cliente = v.id_cliente
                                LEFT JOIN enderecos_cliente e
                                ON e.id_endereco_cliente = v.id_endereco_cliente
                                ORDER BY v.id_venda DESC
                            ";
                            $resultado = mysqli_query($conexao, $sql);
                            if (!$resultado) {
                                die("Erro na consulta: " . mysqli_error($conexao));
                            }
                            while ($linha = mysqli_fetch_assoc($resultado)) {
                                // Garante um status válido
                                $status = $linha['status'] ?? 'criado';
                            ?>
                                <!-- LINHA DO PEDIDO -->
                                <tr class="linha_pedido status-<?php echo htmlspecialchars($status); ?>">
                                    <!-- ID -->
                                    <td class="th">
                                        <?php echo htmlspecialchars($linha['id_venda']); ?>
                                    </td>
                                    <!-- NOME -->
                                    <td class="th">
                                        <?php echo htmlspecialchars($linha['nome']); ?>
                                    </td>
                                    <!-- TELEFONE -->
                                    <td class="th"> <?php echo htmlspecialchars($linha['telefone']); ?>
                                    </td>
                                    <!-- VALOR -->
                                    <td class="th">
                                        R$
                                        <?php echo number_format($linha['total'], 2, ',', '.'); ?>
                                    </td>
                                    <!-- FORMA PAGAMENTO -->
                                    <td class="th">
                                        <?php echo htmlspecialchars($linha['forma_pagamento']); ?>
                                    </td>
                                    <!-- DATA -->
                                    <td class="th">
                                        <?php echo date('d/m/Y H:i', strtotime($linha['data'])); ?>
                                    </td>
                                    <!-- TIPO ENTREGA -->
                                    <td class="th">
                                        <?php echo htmlspecialchars($linha['tipo_entrega']); ?>
                                    </td>
                                    <!-- STATUS -->
                                    <td class="th">
                                        <select name="status" class="select_status" data-id="<?php echo $linha['id_venda']; ?>">
                                            <option value="criado" <?php echo ($status == 'criado') ? 'selected' : ''; ?>>
                                                Criado
                                            </option>
                                            <option value="aceito" <?php echo ($status == 'aceito') ? 'selected' : ''; ?>>
                                                Aceito
                                            </option>
                                            <option value="preparando" <?php echo ($status == 'preparando') ? 'selected' : ''; ?>>
                                                Preparando
                                            </option>
                                            <option value="pronto" <?php echo ($status == 'pronto') ? 'selected' : ''; ?>>
                                                Pronto
                                            </option>
                                            <option value="saiu_para_entrega" <?php echo ($status == 'saiu_para_entrega') ? 'selected' : ''; ?>>
                                                Saiu para entrega
                                            </option>
                                            <option value="entregue" <?php echo ($status == 'entregue') ? 'selected' : ''; ?>>
                                                Entregue
                                            </option>
                                        </select>
                                    </td>
                                    <!-- CANCELAR -->
                                    <td class="th">
                                        <form method="POST" action="cancelar_pedido.php" onsubmit=" return confirm('Tem certeza que deseja cancelar?'); ">
                                            <input type="hidden" name="id_cancelar" value="<?php echo $linha['id_venda']; ?>">
                                            <button class="btn_funcao" type="submit">
                                                ❎
                                            </button>
                                        </form>
                                    </td>
                                    <!-- EDITAR -->
                                    <td class="th">
                                        <button class="btn_funcao" type="button" onclick='popup_editar(
                                                <?= (int) $linha["id_venda"] ?>,
                                                <?= json_encode($linha["tipo_entrega"] ?? "") ?>,
                                                <?= json_encode((float) $linha["total"]) ?>
                                            )'>
                                            📄
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
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
    <!-- =====================================================
        Popup Editar
    ===================================================== -->
    <div id="editar_pedido" class="modal_fundo">
        <div class="modal">
            <button type="button" class="btn_fechar" onclick="fechar_popup_editar()">
                ×
            </button>
            <table id="tabela_editar_pedido" align="center">
                <tr>
                    <th>Nº pedido:</th>
                    <th id="numero_pedido"></th>
                </tr>
                <tr>
                    <th>Nome:</th>
                    <th id="nome"></th>
                </tr>
                <tr>
                    <th colspan="2">Pratos:</th>
                </tr>
                <tr>
                    
                    <th colspan="2">
                        <div id="lista_pratos">
                            Carregando pratos...
                        </div>
                    </th>
                </tr>
                <tr>
                    <th>Total:</th>
                    <th id="total"></th>
                </tr>
                <tr>
                    <th>Tipo de entrega:</th>
                    <th id="tipo_entrega"></th>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn_imprimir">
                            Editar pedido
                        </button>
                    </td>
                    <td>
                        <form method="POST" action="reimprimir_comanda.php" onsubmit="return confirm('Tem certeza que deseja imprimir?');">
                            <input type="hidden" name="id_imprimir" value="<?php echo $linha['id_venda']; ?>">
                            <button class="btn_funcao" type="submit" onclick='reimprimir_comanda.php(
                                                <?= (int) $linha["id_venda"] ?>,
                                                <?= json_encode($linha["nome"] ?? "") ?>
                                                <?= json_encode($linha["telefone"] ?? "") ?>,
                                                <?= json_encode($linha["tipo_entrega"] ?? "") ?>,
                                                <?= json_encode((float) $linha["total"]) ?> )'>
                                Imprimir novamente
                            </button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
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

    // abrir o popup editar
    function popup_editar(id_venda, nome, telefone, tipo_entrega,  total) {
        document.getElementById("numero_pedido").textContent = id_venda;
        document.getElementById("nome").textContent = nome;
        document.getElementById("telefone").textContent = telefone;
        document.getElementById("tipo_entrega").textContent = tipo_entrega;

        const valorTotal = Number(total);

        document.getElementById("total").textContent =
            Number.isFinite(valorTotal)
                ? valorTotal.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
                })
                : "Total indisponível";

        carregarPratos(id_venda);

        document.getElementById("editar_pedido").style.display = "flex";
    }

    // fecha o popup editar pedido
    function fechar_popup_editar() {
        document.getElementById("editar_pedido").style.display = "none";
    }

    function imprimirFechamento() {
        window.print();
    }

    function carregarPratos(idVenda) {
        const lista = document.getElementById("lista_pratos");

        lista.textContent = "Carregando pratos...";

        fetch("buscar_itens_pedido.php?id_venda=" + encodeURIComponent(idVenda))
            .then(response => {
                if (!response.ok) {
                    throw new Error("Erro ao consultar os pratos.");
                }

                return response.json();
            })
            .then(itens => {
                lista.innerHTML = "";

                if (!Array.isArray(itens)) {
                    lista.textContent = itens.erro || "Não foi possível carregar os pratos.";
                    return;
                }

                if (itens.length === 0) {
                    lista.textContent = "Nenhum prato encontrado para este pedido.";
                    return;
                }

                const tabela = document.createElement("table");

                tabela.innerHTML = `
                    <thead>
                        <tr>
                            <th>Prato</th>
                            <th>Quantidade</th>
                            <th>Valor unitário</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                `;

                const tbody = document.createElement("tbody");

                itens.forEach(item => {
                    const linha = document.createElement("tr");

                    const nome = document.createElement("td");
                    nome.textContent = item.nome;
                    nome.classList.add("celula");

                    const quantidade = document.createElement("td");
                    quantidade.textContent = item.quantidade;
                    quantidade.classList.add("celula");

                    const valor = document.createElement("td");
                    valor.textContent = "R$ " + Number(item.valor_unitario).toFixed(2).replace(".", ",");
                    valor.classList.add("celula");

                    const subtotal = document.createElement("td");
                    subtotal.textContent = "R$ " + Number(item.subtotal).toFixed(2).replace(".", ",");
                    subtotal.classList.add("celula");

                    linha.append(nome, quantidade, valor, subtotal);
                    tbody.appendChild(linha);
                });
                tabela.classList.add("tabela-pratos");
                tabela.appendChild(tbody);
                lista.appendChild(tabela);
            })
            .catch(erro => {
                console.error(erro);
                lista.textContent = "Erro ao carregar os pratos do pedido.";
            });
    }
</script>