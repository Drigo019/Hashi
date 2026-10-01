<?php
    session_start();
    require 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body">
    <div style="display: flex;">
        <!-- MENU -->
        <div style="display: flex;">
            <div id="menu">
                <div id="inicio" align="center">
                    <button type="button" class="btn"
                        onclick="window.location.href='inicio.html'">
                        <img class="icons_menu" src="icons/casa.png">
                        <div style="font-size: 18px;">
                            Início
                        </div>
                    </button>
                </div>
                <div id="novo_pedido" align="center">
                    <button type="button" class="btn"
                        onclick="window.location.href='novo_pedido.php'">
                        <img class="icons_menu"
                            src="icons/carrinho_adicionar.png">
                        <div style="font-size: 18px;">
                            Novo Pedido
                        </div>
                    </button>
                </div>
                <div align="center">
                    <button type="button" class="btn"
                        onclick="window.location.href='ver_pedidos.php'">
                        <img class="icons_menu" src="icons/pedido.png">
                        <div style="font-size: 18px;">
                            Ver Pedidos
                        </div>
                    </button>
                </div>
                <div align="center">
                    <button type="button" class="btn" onclick="window.location.href='produtos.html'">
                        <img class="icons_menu" src="icons/prato.png">
                        <div style="font-size: 18px;">Pratos</div>
                    </button>
                </div>
                <div align="center">
                    <button type="button" class="btn" onclick="window.location.href=''">
                        <img class="icons_menu" src="icons/">
                        <div style="font-size: 18px;">
                            Cadastrar Fornecedor
                        </div>
                    </button>
                </div>
            </div>
            <!-- BOTÃO DO MENU -->
            <div>
                <button type="button" id="btn_menu" onclick="alternarDiv()">
                    <img id="ico_menu" src="icons/seta_direita.png" align="right">
                </button>
            </div>
        </div>
        <div display="flex" style="width: 100%;">
            <div align="right" style="width: 95%; height: 10vh;">
                <button onclick="abrir_popup_cadstro_produto()" style="width: 140px; height: 50px; margin-top: 6px; ">
                    Cadastrar Produto
                </button>
            </div>
            <!-- ==========================
                TABELA
            =========================== -->
            <div style=" border: 1px solid; width: 100%; height: 90vh;" >
                <div id="area_tabela_pratos" >
                    <table border="1" id="table_pratos" >
                        <!-- CABEÇALHO -->
                        <tr class="tr">
                            <th class="th_titulo">
                                ID
                            </th>
                            <th class="th_titulo">
                                Nome
                            </th>
                            <th class="th_titulo">
                                Valor
                            </th>
                            <th class="th_titulo">
                                Categoria
                            </th>
                            <th class="th_titulo" colspan="2    " >
                                Funções
                            </th>
                        </tr>
                        <?php
                        $sql = "
                            SELECT p.id_produto, p.nome, p.valor, p.categoria
                            FROM produtos p
                            ORDER BY p.id_produto ASC
                        ";
                        $resultado = mysqli_query( $conexao, $sql );
                        if (!$resultado) {
                            die("Erro na consulta: ". mysqli_error($conexao));
                        }
                        while ($linha =mysqli_fetch_assoc($resultado)) {
                        ?>
                            <!-- LINHA DO PEDIDO -->
                            <tr class="">
                                <!-- ID -->
                                <td class="th">
                                    <?php echo htmlspecialchars( $linha['id_produto'] ); ?>
                                </td>
                                <!-- NOME -->
                                <td class="th">
                                    <?php echo htmlspecialchars( $linha['nome'] ); ?>
                                </td>
                                <!-- VALOR -->
                                <td class="th">
                                    R$
                                    <?php echo number_format( $linha['valor'], 2, ',', '.' ); ?>
                                </td>
                                <!-- CATEGORIA -->
                                <td class="th">
                                    <?php echo htmlspecialchars( $linha['categoria'] ); ?>
                                </td>
                                <!-- CANCELAR -->
                                <td class="th">
                                    <form method="POST" action="deletar_produto.php" onsubmit=" return confirm( 'Tem certeza que deseja cancelar?' ); " >
                                        <input type="hidden" name="id_cancelar" value="<?php echo $linha['id_produto']; ?>" >
                                        <button class="btn_funcao" type="submit" >
                                            ❎
                                        </button>
                                    </form>
                                </td>
                                <!-- EDITAR -->
                                <td class="th">
                                    <form method="POST" action="editar_produto.php" onsubmit=" return confirm('Tem certeza que deseja editar?'); " >
                                        <input type="hidden" name="id_editar" value="<?php echo $linha['id_produto']; ?>" >
                                        <button class="btn_funcao" type="submit" >
                                            📄
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
    <!-- =====================================================
        POPUP CADASTRO DE PRATO
    ===================================================== -->
    <div id="cadastro_prato" class="modal_fundo">
        <div class="modal">
            <button type="button"class="btn-fechar"onclick="fechar_cadastro_prato()">
                ×
            </button>
            <form action="cadastrar_produto.php" method="post">
                    <!-- ÁREA PRINCIPAL -->
                    <div style="width: 100%;">
                        <!-- FORMULÁRIO -->
                        <form action="cadastrar_produto.php" method="POST">
                            <div style=" display: flex; justify-content: center; align-items: center; width: 100%;">
                                <table class="table_cadastro">
                                    <!-- NOME -->
                                    <tr>
                                        <td>
                                            Nome:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="nome" required>
                                        </td>
                                    </tr>
                                    <!-- VALOR -->
                                    <tr>
                                        <td>
                                            Valor:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="number" name="valor" step="0.01" min="0" required>
                                        </td>
                                    </tr>
                                    <!-- CATEGORIA -->
                                    <tr>
                                        <td>
                                            Categoria:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="categoria" required>
                                                <option value=""> Selecione uma categoria </option>
                                                <option value="prato quente"> Prato quente</option>
                                                <option value="entrada"> Entrada </option>
                                                <option value="poke"> Poke </option>
                                                <option value="temaki"> Temaki </option>
                                                <option value="hot roll"> Hot roll </option>
                                                <option value="hossomaki"> Hossomaki </option>
                                                <option value="uramaki"> Uramaki </option>
                                                <option value="especial"> Especial </option>
                                                <option value="combinado"> Combinado </option>
                                                <option value="sobremesa"> Sobremesa </option>
                                                <option value="refrigerante"> Refrigerante </option>
                                                <option value="cerveja"> Cerveja </option>
                                                <option value="agua"> Água </option>
                                                <option value="suco"> Suco </option>
                                                <option value="promocao"> Promoção </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <!-- DESCRIÇÃO -->
                                    <tr>
                                        <td>
                                            Descrição:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="descricao">
                                        </td>
                                    </tr>
                                    <!-- BOTÃO -->
                                    <tr>
                                        <td align="center">
                                            <button type="submit">
                                                Cadastrar
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>  
            </form>
        </div>
    </div>
    <script>
            // =====================================================
        // Popup
        // =====================================================
        function abrir_popup_cadstro_produto() {
                document.getElementById("cadastro_prato").style.display = "flex";
            }
        function fechar_cadastro_prato() {
            document.getElementById("cadastro_prato").style.display = "none";
        }
        // Fechar clicando no fundo escuro
        document.getElementById("cadastro_prato").addEventListener("click", function(event) {
            if (event.target === this) {
                fechar_cadastro_prato();
            }
        });
    </script>
    <!-- JAVASCRIPT -->
    <script src="script.js"></script>
</body>
</html>