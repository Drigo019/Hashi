<?php
    require 'conexao.php';
    require 'cadastro_venda.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body">
    <div style="display: flex;">
        <div style="display: flex;">
            <div id="menu">
                <div id="inicio" align="center" >
                    <button class="btn" onclick="window.location.href='inicio.html'">
                        <img class="icons_menu" src="icons/casa.png">
                        <div style="font-size: 18px;">Início</div>
                    </button>
                </div>
                <div id="novo_pedido" align="center">
                    <button class="btn" onclick="window.location.href='novo_pedido.html'">
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
                        <button class="btn" onclick="window.location.href='acrescimo.html'">
                            <img class="icons_menu" src="icons/acrecimo.png">
                            <div style="font-size: 18px;">Acrécimos</div>
                        </button>
                    </div>
                <div id="" align="center">
                    <button class="btn" onclick="window.location.href=''">
                        <img class="icons_menu" src="icons/panela.png">
                        <div style="font-size: 18px;">Produtos</div>
                    </button>
                </div>

                <div id="" align="center">
                    <button class="btn" onclick="window.location.href=''">
                        <img class="icons_menu" src="">
                        <div style="font-size: 18px;"></div>
                    </button>
                </div>
                <div id="" align="center">
                    <button class="btn" onclick="window.location.href=''">
                        <img class="icons_menu" src="">
                        <div style="font-size: 18px;"></div>
                    </button>
                </div>
            </div>
            <div>
                <button id="btn_menu" onclick="alternarDiv()">
                    <img id="ico_menu" src="icons/seta_direita.png" align="right">
                </button>
            </div>
            <div style="display: grid;">
                <div style="border: 1px solid; width: 98vw; height: 20vh;">
                    <div style="display: flex; height: 100%; margin-top: 20px;">
                        <div style="width: 30%;" align="center">
                            <input type="text" name="barra_pesquisa_pedidos" id="barra_pesquisa_pedidos" >
                            <button id="btn_pesquisa_pedidos" onclick="pesquisarPedidos()">🔍</button>
                        </div>
                        <div id="botoes" align="center" style="width: 50%;">
                            <div id="botoes_status">
                                <input type="button" value="concluido" id="concluido">
                                <input type="button" value="cancelado" id="cancelado">
                            </div>
                            <br>
                            <div id="botoes_data">
                                <input type="button" value="ontem" id="ontem">
                                <input type="button" value="hoje" id="hoje">
                                <input type="button" value="semana" id="semana">
                                <input type="button" value="mes" id="mes">
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div style="border: 1px solid; width: 98vw; height: 80vh;">
                    <div id="area_tabela">
                        <table border="1" id="table_clientes">

                            <tr class="tr">
                                <th class="th_titulo">ID</th>
                                <th class="th_titulo">Nome</th>
                                <th class="th_titulo">Telefone</th>
                                <th class="th_titulo">Valor</th>
                                <th class="th_titulo">Forma de pagamento</th>
                                <th class="th_titulo">Data</th>
                                <th class="th_titulo" colspan="4">Funções</th>
                            </tr>

                            <?php 
                                $sql = "SELECT * FROM vendas";
                                $resultado = mysqli_query($conexao, $sql); 
                                while($linha = $resultado->fetch_assoc()) { 
                            ?>

                            <tr class="tr">
                                <td class="th"><?php echo htmlspecialchars($linha['id_venda']); ?></td>
                                <td class="th"><?php echo htmlspecialchars($linha['nome']); ?></td>
                                <td class="th"><?php echo htmlspecialchars($linha['telefone']); ?></td> 
                                <td class="th"><?php echo htmlspecialchars($linha['valor']); ?></td>
                                <td class="th"><?php echo htmlspecialchars($linha['data']); ?></td>
                                <td class="th"><?php echo htmlspecialchars($linha['status']); ?></td>

                                <td class="th">
                                    <form method="POST" action="concluir_pedido.php" onsubmit="return confirm('Tem certeza que deseja concluir?');">
                                        <input type="hidden" name="id_concluir" value="<?php echo $linha['id_venda']; ?>">
                                        <button class="btn_funcao" type="submit">
                                            ✅
                                        </button>
                                    </form>
                                </td>
                                <td class="th">
                                    <form method="POST" action="cancelar_pedido.php" onsubmit="return confirm('Tem certeza que deseja cancelar?');">
                                        <input type="hidden" name="id_cancelar" value="<?php echo $linha['id_venda']; ?>">
                                        <button class="btn_funcao" type="submit">
                                            ❎
                                        </button>
                                    </form>
                                </td>
                                <td class="th">
                                    <form method="POST" action="editar.php" onsubmit="return confirm('Tem certeza que deseja editar?');">
                                        <input type="hidden" name="id_editar" value="<?php echo $linha['id_venda']; ?>">
                                        <button class="btn_funcao" type="submit">
                                            📄
                                        </button>
                                    </form>
                                </td>
                                <td class="th">
                                    <form method="POST" action="imprimir.php" onsubmit="return confirm('Tem certeza que deseja imprimir?');">
                                        <input type="hidden" name="id_imprimir" value="<?php echo $linha['id_venda']; ?>">
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