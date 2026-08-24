<?php
    require 'conexao.php';?>
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
                    <button class="btn" onclick="window.location.href='inicio.html'" >
                        <img class="icons_menu" src="icons/casa.png" >
                        <div style="font-size: 18px;">
                            Início
                        </div>
                    </button>
                </div>
                <div id="novo_pedido" align="center">
                    <button class="btn" onclick="window.location.href='novo_pedido.php'" >
                        <img class="icons_menu" src="icons/carrinho_adicionar.png" >
                        <div style="font-size: 18px;">
                            Novo Pedido
                        </div>
                    </button>
                </div>
                <div align="center">
                    <button class="btn" onclick="window.location.href='ver_pedidos.php'" >
                        <img class="icons_menu" src="icons/pedido.png" >
                        <div style="font-size: 18px;">
                            Ver Pedidos
                        </div>
                    </button>
                </div>
            </div>
            <!-- BOTÃO DO MENU -->
            <div>
                <button id="btn_menu" onclick="alternarDiv()" >
                    <img id="ico_menu" src="icons/seta_direita.png" >
                </button>
            </div>
            <!-- ==========================
                 CONTEÚDO
            =========================== -->
            <div style="display: grid;">
                <!-- ==========================
                     ÁREA DE PESQUISA
                =========================== -->
                <div class="area_filtros" style=" border: 1px solid; width: 98vw; height: 20vh; " >
                    <div style=" display: flex; height: 100%; margin-top: 20px; " >
                        <!-- PESQUISA -->
                        <div style="width: 30%;" align="center" >
                            <input type="text" name="barra_pesquisa_pedidos" id="barra_pesquisa_pedidos" >
                            <button id="btn_pesquisa_pedidos" onclick="pesquisarPedidos()" >
                                🔍
                            </button>
                        </div>
                        <!-- BOTÕES -->
                        <div id="botoes" align="center" style="width: 50%;" >
                            <div id="botoes_status">
                                <input type="button" value="concluido" id="concluido" >
                                <input type="button" value="cancelado" id="cancelado" >
                            </div>
                            <br>
                            <div id="botoes_data">
                                <input type="button" value="ontem" id="ontem" >
                                <input type="button" value="hoje" id="hoje">
                                <input type="button" value="semana" id="semana" >
                                <input type="button" value="mes" id="mes" >
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ==========================
                     TABELA
                =========================== -->
                <div style=" border: 1px solid; width: 98vw; height: 80vh; " >
                    <div id="area_tabela">
                        <table border="1" id="table_clientes" >
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
                                <th class="th_titulo" colspan="3" >
                                    Funções
                                </th>
                            </tr>
                            <?php
                            $sql = "
                                SELECT
                                    v.id_venda,
                                    c.nome,
                                    c.telefone,
                                    v.total,
                                    v.forma_pagamento,
                                    v.tipo_entrega,
                                    v.data,
                                    v.status
                                FROM vendas v
                                JOIN clientes c
                                ON c.id_cliente = v.id_cliente
                                LEFT JOIN enderecos_cliente e
                                ON e.id_endereco_cliente = v.id_endereco_cliente
                                ORDER BY v.id_venda DESC
                            ";
                            $resultado = mysqli_query( $conexao, $sql );
                            if (!$resultado) {
                                die("Erro na consulta: ". mysqli_error($conexao));
                            }
                            while ($linha =mysqli_fetch_assoc($resultado)) {
                                // Garante um status válido
                                $status = $linha['status'] ?? 'criado';
                            ?>
                                <!-- LINHA DO PEDIDO -->
                                <tr class="linha_pedido status-<?php echo htmlspecialchars($status); ?>">
                                    <!-- ID -->
                                    <td class="th">
                                        <?php echo htmlspecialchars( $linha['id_venda'] ); ?>
                                    </td>
                                    <!-- NOME -->
                                    <td class="th">
                                        <?php echo htmlspecialchars( $linha['nome'] ); ?>
                                    </td>
                                    <!-- TELEFONE -->
                                    <td class="th"> <?php echo htmlspecialchars( $linha['telefone'] ); ?>
                                    </td>
                                    <!-- VALOR -->
                                    <td class="th">
                                        R$
                                        <?php echo number_format( $linha['total'], 2, ',', '.' ); ?>
                                    </td>
                                    <!-- FORMA PAGAMENTO -->
                                    <td class="th">
                                        <?php echo htmlspecialchars( $linha['forma_pagamento'] ); ?>
                                    </td>
                                    <!-- DATA -->
                                    <td class="th">
                                        <?php echo date( 'd/m/Y H:i', strtotime( $linha['data'] ) ); ?>
                                    </td>
                                    <!-- TIPO ENTREGA -->
                                    <td class="th">
                                        <?php echo htmlspecialchars( $linha['tipo_entrega'] ); ?>
                                    </td>
                                    <!-- STATUS -->
                                    <td class="th">
                                        <select name="status" class="select_status" data-id="<?php echo $linha['id_venda']; ?>" >
                                            <option value="criado" <?php echo ( $status == 'criado' ) ? 'selected' : ''; ?> >
                                                Criado
                                            </option>
                                            <option value="aceito" <?php echo ( $status == 'aceito' ) ? 'selected' : ''; ?> >
                                                Aceito
                                            </option>
                                            <option value="preparando" <?php echo ( $status == 'preparando' ) ? 'selected' : ''; ?> >
                                                Preparando
                                            </option>
                                            <option value="pronto" <?php echo ( $status == 'pronto' ) ? 'selected' : ''; ?> >
                                                Pronto
                                            </option>
                                            <option value="saiu_para_entrega" <?php echo ( $status == 'saiu_para_entrega' ) ? 'selected' : ''; ?> >
                                                Saiu para entrega
                                            </option>
                                            <option value="entregue" <?php echo ( $status == 'entregue' ) ? 'selected' : ''; ?> >
                                                Entregue
                                            </option>
                                        </select>
                                    </td>
                                    <!-- CANCELAR -->
                                    <td class="th">
                                        <form method="POST" action="cancelar_pedido.php" onsubmit=" return confirm( 'Tem certeza que deseja cancelar?' ); " >
                                            <input type="hidden" name="id_cancelar" value="<?php echo $linha['id_venda']; ?>" >
                                            <button class="btn_funcao" type="submit" >
                                                ❎
                                            </button>
                                        </form>
                                    </td>
                                    <!-- EDITAR -->
                                    <td class="th">
                                        <form method="POST" action="editar.php" onsubmit=" return confirm('Tem certeza que deseja editar?'); " >
                                            <input type="hidden" name="id_editar" value="<?php echo $linha['id_venda']; ?>" >
                                            <button class="btn_funcao" type="submit" >
                                                📄
                                            </button>
                                        </form>
                                    </td>
                                    <!-- IMPRIMIR -->
                                    <td class="th">
                                        <form method="POST" action="imprimir_comanda_novamente.php" onsubmit="return confirm('Tem certeza que deseja imprimir?');">
                                            <input type="hidden" name="id_imprimir" value="<?php echo $linha['id_venda'];?>">
                                            <button class="btn_funcao" type="submit">
                                                🖨️
                                            </button>
                                        </form>
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
</body>
</html>