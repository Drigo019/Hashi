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
        </div>
        
        <div style="display: flex; width: 100%; height: 100vh;">
            <div class="div_nov_ped" align="center">
                <form action="imprimir_comanda.php" method="POST" onsubmit="prepararEnvio()">
                <div class="categoria_pratos"> 
                    <h2> Pratos Quentes </h2>
                    <button type="button" onclick="adicionarAoCarrinho('Prato Feito', 25.00)">Prato Feito</button>
                    <button type="button" onclick="adicionarAoCarrinho('Lasanha', 30.00)">Lasanha</button>
                    <button type="button" onclick="adicionarAoCarrinho('Hambúrguer', 20.00)">Hambúrguer</button>
                </div>
                <div>

                </div>
            </div>
            <div class="div_nov_ped">
                <div align="center">
                    <h2>Carrinho:</h2>
                </div>
                <input type="hidden" name="carrinho_lista" id="carrinho_hidden">
                <input type="hidden" name="itens" id="itens_hidden"><div id="carrinho_lista"></div>
                <button onclick="limparCarrinho()">Limpar Carrinho</button>
            </div>
            <div class="div_nov_ped" id="comanda">
                <div id="div_dados" class="tabela"> 
                    <div>
                        
                        <table  align="center">
                            <tr>
                                <td colspan="2" style="text-align: center;"><h2>Dados do cliente:</h2></td>
                            </tr>
                            <tr>
                                <td class="td_pedido">Telefone:</td>
                                <td class="td_pedido"><input type="text" name="telefone" id="telefone" style="font-size: 20px;" required></td>
                            </tr>
                            <tr>
                                <td class="td_pedido">Nome:</td>
                                <td class="td_pedido"><input type="text" name="nome" id="nome" style="font-size: 20px;" required></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div>
                    <div id="div_entrega" class="tabela">
                        <table align="center">
                            <tr>
                                <td colspan="2"><h2>Envio do pedido:</h2></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="td_pedido">
                                    <select class="select"  name="tipo_entrega" id="tipo_entrega">
                                        <option value="retirada" selected>Retirada</option>
                                        <option value="entregar">Entregar</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table align="center" id="endereco" style="display: none;">
                            <tr>
                                <td class="td_pedido" >Rua:</td>
                                <td class="td_pedido"><input type="text" name="rua" id="rua" style="font-size: 20px;"></td>
                            </tr>
                            <tr>
                                <td class="td_pedido">Número:</td>
                                <td class="td_pedido"><input type="number" name="numero" id="numero" style="font-size: 20px;"></td>
                            </tr>
                            <tr>
                                <td class="td_pedido">Bairro:</td>
                                <td class="td_pedido">
                                    <select name="bairro" id="bairro">
                                        <option value=""></option>
                                        <option value="bairro2">Por do sol</option>
                                        <option value="bairro3">Bairro 3</option>
                                        <option value="bairro4">Bairro 4</option>
                                        <option value="bairro5">Bairro 5</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_pedido">Observação:</td>
                                <td class="td_pedido"><input type="text" name="obs_estrega" id="obs_estrega" style="font-size: 20px;"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tabela">
                    <div id="div_form_pag">
                        <table  align="center">
                            <tr>
                                <td class="td_pedido">
                                    Total: R$ 
                                </td>
                                <td class="td_pedido">
                                    <input type="text" id="total_visivel" style="font-size: 20px;" readonly >
                                    <input type="hidden" name="total" id="total_hidden">
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="td_pedido">Forma de pagamento:</td>
                                <td class="td_pedido">
                                    <select class="select" name="form_pag" id="form_pag">
                                        <option value="dinheiro">Dinheiro</option>
                                        <option value="cartao">Cartão</option>
                                        <option value="pix">Pix</option>
                                        <option value="fiado">Fiado</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_pedido">Observação:</td>
                                <td class="td_pedido"><input type="text" name="obs_pagamento" id="obs_pagamento" style="font-size: 20px;"></td>  
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    <button type="submit" style="background-color: #990000ab; color: white; border: none; padding: 10px 20px; cursor: pointer;">Imprimir Comanda</button>
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
    <script src="entrega.js"></script>
    <script src="script.js"></script>
    <script>
        let carrinho = [];

        function adicionarAoCarrinho(nome, preco) {
            let itemExistente = carrinho.find(item => item.nome === nome);

            if (itemExistente) {
                itemExistente.qtd += 1;
            } else {
                carrinho.push({
                    nome: nome,
                    preco: Number(preco),
                    qtd: 1
                });
            }

            atualizarCarrinho();
        }

        function removerItem(index) {
            carrinho.splice(index, 1);
            atualizarCarrinho();
        }

        function limparCarrinho() {
            carrinho = [];
            atualizarCarrinho();
        }

        function atualizarCarrinho() {
            let lista = document.getElementById("carrinho_lista");
            lista.innerHTML = "";

            let total = 0;

            carrinho.forEach((item, index) => {
                let div = document.createElement("div");

                let subtotal = item.preco * item.qtd;
                total += subtotal;

                div.innerHTML = `
                    ${item.nome} (x${item.qtd}) - R$ ${subtotal.toFixed(2)}
                    <button onclick="removerItem(${index})">❌</button>
                `;

                 lista.appendChild(div); // cada item vira uma linha
            });

            document.getElementById("total_visivel").value = total.toFixed(2);
            document.getElementById("total_hidden").value = total.toFixed(2);
        }

        function prepararEnvio() {
            let listaTexto = "";
            let itens = [];

            carrinho.forEach(item => {
                let linha = `${item.nome} (x${item.qtd}) - R$ ${(item.preco * item.qtd).toFixed(2)}`;

                listaTexto += linha + "<br>";

                itens.push({
                    nome: item.nome,
                    qtd: item.qtd,
                    preco: item.preco
                });
            });

            document.getElementById("carrinho_hidden").value = listaTexto;
            document.getElementById("itens_hidden").value = JSON.stringify(itens);
        }

    </script>
</body>
</html>