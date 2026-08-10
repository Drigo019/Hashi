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
            </div>
            <div>
                <button id="btn_menu" onclick="alternarDiv()">
                    <img id="ico_menu" src="icons/seta_direita.png" align="right">
                </button>
            </div>
        </div>
        
        <div style="display: flex; width: 100%; height: 100vh;">
            <div class="div_nov_ped" align="center" style="overflow-y: auto; height: 100vh;">
                <form action="imprimir_comanda.php" method="POST" onsubmit="prepararEnvio()">
                <div class="categoria_pratos" style="display: grid;"> 
                    <h2> PRATOS QUENTES </h2>
                    <button type="button" onclick="adicionarAoCarrinho('Bentô box teppan de salmão', 55.00)">Bentô box teppan de salmão</button>
                    <button type="button" onclick="adicionarAoCarrinho('Bentô box de tilápia', 35.00)">Bentô box de tilápia</button>
                    <button type="button" onclick="adicionarAoCarrinho('Bentô box de Yakisoba', 35.00)">Bentô box de Yakisoba</button>
                    <button type="button" onclick="adicionarAoCarrinho('Bentô box de Shimeji', 35.00)">Bentô box de Shimeji</button>
                    <button type="button" onclick="adicionarAoCarrinho('Bentô box de frango xadrez', 35.00)">Bentô box de frango xadrez</button>
                    <button type="button" onclick="adicionarAoCarrinho('Bentô box de frango com laranja', 35.00)">Bentô box de frango com laranja</button>
                    <button type="button" onclick="adicionarAoCarrinho('Lombo agridoce', 33.00)">Lombo agridoce</button>
                    <button type="button" onclick="adicionarAoCarrinho('Frango com laranja', 33.00)">Frango com laranja</button>
                    <button type="button" onclick="adicionarAoCarrinho('Peixe frito', 45.00)">Peixe frito</button>
                    <button type="button" onclick="adicionarAoCarrinho('Frango xadrez', 33.00)">Frango xadrez</button>
                    <button type="button" onclick="adicionarAoCarrinho('Yakisoba vegetariano', 22.00)">Yakisoba vegetariano</button>
                    <button type="button" onclick="adicionarAoCarrinho('Yakisoba tradiconal', 25.00)">Yakisoba tradiconal</button>
                    <button type="button" onclick="adicionarAoCarrinho('Yakisoba de Camarão',37.00)">Yakisoba de Camarão</button>
                </div>
                <div class="categoria_pratos" style="display: grid">
                    <h2> ENTRADAS</h2>
                    <button type="button" onclick="adicionarAoCarrinho('Ceviche de tilápia', 40.00)">Ceviche de tilápia</button>
                    <button type="button" onclick="adicionarAoCarrinho('Ceviche de salmão', 65.00)">Ceviche de salmão</button>
                    <button type="button" onclick="adicionarAoCarrinho('Shimeji na manteiga', 35.00)">Shimeji na manteiga</button>
                    <button type="button" onclick="adicionarAoCarrinho('Guioza', 18.00)">Guioza</button>
                    <button type="button" onclick="adicionarAoCarrinho('Harumaki tradicional', 14.00)">Harumaki tradicional</button>
                    <button type="button" onclick="adicionarAoCarrinho('Harumaki 2 queijo', 14.00)">Harumaki 2 queijo</button>
                    <button type="button" onclick="adicionarAoCarrinho('Hariumaki vegetariano', 14.00)">Harumaki vegetarino</button>
                    <button type="button" onclick="adicionarAoCarrinho('Harumaki de camrão', 16.00)">Harumaki de camrão</button>
                    <button type="button" onclick="adicionarAoCarrinho('Sonomono', 8.00)">Sonomono</button>
                    <button type="button" onclick="adicionarAoCarrinho('Oniguiri', 10.00)">Oniguiri</button>
                    <button type="button" onclick="adicionarAoCarrinho('Tartare', 30.00)">Tartare</button>
                </div>
                <div class="categoria_pratos" style="display: grid">
                    <h2> POKES </h2>
                    <button type="button" onclick="adicionarAoCarrinho('Poke só salmão', 38.00)">Poke só salmão</button>
                    <button type="button" onclick="adicionarAoCarrinho('Poke de salmão filadelfia',38.00)">Poke de salmão filadelfia</button>
                    <button type="button" onclick="adicionarAoCarrinho('Poke de shimeji', 38.00)">Poke de shimeji</button>
                    <button type="button" onclick="adicionarAoCarrinho('Poke de tilápia', 38.00)">Poke de tilápia</button>
                    <button type="button" onclick="adicionarAoCarrinho('Poke de camarão', 38.00)">Poke de camarão</button>
                    <button type="button" onclick="adicionarAoCarrinho('Poke de frango', 38.00)">Poke de frango</button>
                    <button type="button" onclick="adicionarAoCarrinho('Acrécimo de Proteina', 12.00)">Acrécimo de Proteina</button>
                </div>
                <div class="categoria_pratos" style="display: grid;">
                    <h2> TEMAKIS </h2>
                    <button type="button" onclick="adicionarAoCarrinho('Temaki Filadelfia', 32.00)">Temaki Filadelfia</button>
                    <button type="button" onclick="adicionarAoCarrinho('Temaki de camarão crisp', 33.00)">Temaki de camarão crisp</button>
                    <button type="button" onclick="adicionarAoCarrinho('Temaki só salmão', 33.00)">Temaki só salmão</button>
                    <button type="button" onclick="adicionarAoCarrinho('Temaki de shimeji', 30.00)">Temaki de shimeji</button>
                    <button type="button" onclick="adicionarAoCarrinho('Temaki hot', 35.00)">Temaki hot</button>
                    <button type="button" onclick="adicionarAoCarrinho('Fritar Temaki', 5.00)">Fritar Temaki</button>
                    <button type="button" onclick="adicionarAoCarrinho('Temaki sem arroz', 8.00)">Temaki sem arroz</button>
                </div>
                <div class="categoria_pratos" style="display: grid;">
                    <h2> HOT ROLL</h2>
                    <button type="button" onclick="adicionarAoCarrinho('Mini hot', 18.00)">Mini hot</button>
                    <button type="button" onclick="adicionarAoCarrinho('Hot roll', 20.00)">Hot roll</button>
                    <button type="button" onclick="adicionarAoCarrinho('Ebi hot', 22.00)">Ebi hot</button>
                    <button type="button" onclick="adicionarAoCarrinho('Super hot', 50.00)">Super hot</button>
                </div> 
                <div class="categoria_pratos" style="display: grid;">
                    <h2> HOSSOMAKIS </h2>
                    <button type="button" onclick="adicionarAoCarrinho('Hossomaki de kani', 14.00)">Hossomaki de kani</button>
                    <button type="button" onclick="adicionarAoCarrinho('Hossomaki de salmão', 16.00)">Hossomaki de salmão</button>
                    <button type="button" onclick="adicionarAoCarrinho('Hossomaki de pepino', 14.00)">Hossomaki de pepino</button>
                    <button type="button" onclick="adicionarAoCarrinho('Hossomaki de salmão grelhado', 18.00)">Hossomaki de sakmão grelhado</button>
                </div>
                <div class="categoria_pratos" style="display: grid;">
                    <h2> URAMAKIS </h2>
                    <button type="button" onclick="adicionarAoCarrinho('Uramaki de salmão filadelfia', 16.00)">Uramaki de salmão filadelfia</button>
                    <button type="button" onclick="adicionarAoCarrinho('Uramaki de kani', 18.00)">Uramaki de kani</button>
                    <button type="button" onclick="adicionarAoCarrinho('Uramaki de camarão', 18.00)">Uramaki de kani</button>
                    <button type="button" onclick="adicionarAoCarrinho('Uramaki de salmão grelhado', 18.00)">Uramaki de salmão grelhado</button>
                </div>
                <div class="categoria_pratos" style="display: grid;">
                    <h2> ESPECIAIS </h2>
                    <button type="button" onclick="adicionarAoCarrinho('Sashimi de salmão', 25.00)">Sashimi de salmão</button> 
                    <button type="button" onclick="adicionarAoCarrinho('Sashimi de tilápia', 20.00)">Sashimi de tilápia</button>
                    <button type="button" onclick="adicionarAoCarrinho('Jyo de salmão', 20.00)">Jyo de salmão</button>
                    <button type="button" onclick="adicionarAoCarrinho('Jyo maçaricado', 25.00)">Jyo Maçaricado</button>
                    <button type="button" onclick="adicionarAoCarrinho('ebi jyo', 25.00)">Ebi jyo</button>
                    <button type="button" onclick="adicionarAoCarrinho('Dragon', 23.00)">Dragon</button>
                </div>
                <div class="categoria_pratos" style="display: grid;">
                    <h2> COMBINADOS </h2>
                    <button type="button" onclick="adicionarAoCarrinho('Combinado 1', 55.00)">Combinado 1</button>
                    <button type="button" onclick="adicionarAoCarrinho('Combinado 2', 65.00)">Combinado 2</button>
                    <button type="button" onclick="adicionarAoCarrinho('Combinado 3', 80.00)">Combinado 3</button>
                    <button type="button" onclick="adicionarAoCarrinho('Combinado 4', 105.00)">Combinado 4</button>
                    <button type="button" onclick="adicionarAoCarrinho('Combinado 5', 130.00)">Combinado 5</button>
                    <button type="button" onclick="adicionarAoCarrinho('Combinado 6', 120.00)">Combinado 6</button>
                    <button type="button" onclick="adicionarAoCarrinho('Rodízio delivery', 110.00)">Rodízio delivery</button>
                    <button type="button" onclick="adicionarAoCarrinho('Rodízio casl', 150.00)">Rodízio casal</button>
                    <button type="button" onclick="adicionarAoCarrinho('Rodana rodízio', 35.00)">Rodana Rodízio</button>
                    <button type="button" onclick="adicionarAoCarrinho('Hiroshima', 100.00)">Hiroshima</button>
                    <button type="button" onclick="adicionarAoCarrinho('Combinado de 40 peças (especial)', 65.00)">Combiando 40 peças (especial)</button>
                    <button type="button" onclick="adicionarAoCarrinho('Acrécimo de hot roll', 10.00)">Acrécimo de hot roll</button>
                    <button type="button" onclick="adicionarAoCarrinho('Fritar o temaki do combiando', 5.00)">Fritar o temaki do combinado</button>
                    <button type="button" onclick="adicionarAoCarrinho('Combinado todo salmão', 10.00)">Combinado todo salmão</button>
                    <button type="button" onclick="adicionarAoCarrinho('Combiando sem nada cru', 10.00)">Combinado sem nada cru</button>
                </div>
                <div class="categoria_pratos" style="display: grid;">
                    <h2> BEBIDAS: </h2>
                    <div class="categoria_pratos" style="display: grid; margin-left: 8px;">
                        <h3> REFRIGERANTES </h3>
                        <button type="button" onclick="adicionarAoCarrinho('Coca lata normal', 6.00)">Coca lata normal</button>
                        <button type="button" onclick="adicionarAoCarrinho('Coca lata zero', 6.00)">Coca lata zero</button>
                        <button type="button" onclick="adicionarAoCarrinho('Coca 600ml normal', 8.00)">Coca 600ml normal</button>
                        <button type="button" onclick="adicionarAoCarrinho('Coca 60ml zero', 8.00)">Coca 600ml zero</button>
                        <button type="button" onclick="adicionarAoCarrinho('Coca 1,5L normal', 15.00)">Coca 1,5L normal</button>
                        <button type="button" onclick="adicionarAoCarrinho('Coca 1,5L zero', 15.00)">Coca 1,5L zero</button>
                        <button type="button" onclick="adicionarAoCarrinho('Guaraná lata normal', 6.00)">Guaraná lata normal</button>
                        <button type="button" onclick="adicionarAoCarrinho('Guaraná lata zero', 6.00)">Guaraná lata zero</button>
                        <button type="button" onclick="adicionarAoCarrinho('Guaraná 1L', 7.00)">Guaraná 1L</button>
                        <button type="button" onclick="adicionarAoCarrinho('Tonica lata normal', 6.00)">Tonica Lata normal</button>
                        <button type="button" onclick="adicionarAoCarrinho('Tonica lata zero', 6.00)">Tonica lata zero</button>
                        <button type="button" onclick="adicionarAoCarrinho('Fanta lata uva', 6.00)">Fanta lata uva</button>
                        <button type="button" onclick="adicionarAoCarrinho('Fanta lata laranja', 6.00)">Fanta lata Laranja</button>
                        <button type="button" onclick="adicionarAoCarrinho('H2O limão', 7.00)">H2O limão</button>
                        <button type="button" onclick="adicionarAoCarrinho('H2O limoneto', 7.00)">H2O limoneto</button>
                    </div>
                    <div  class="categoria_pratos" style="display: grid; margin-left: 8px;">
                        <h2> CERVEJAS </h2>
                        <button type="button" onclick="adicionarAoCarrinho('Brahma lata', 6.00)">Brahma lata</button>
                        <button type="button" onclick="adicionarAoCarrinho('Amistel lata', 6.00)">Amistel lata</button>
                        <button type="button" onclick="adicionarAoCarrinho('Antartica lata', 6.00)">Antartica lata</button>
                        <button type="button" onclick="adicionarAoCarrinho('Skol', 6.00)">Skol</button>
                        <button type="button" onclick="adicionarAoCarrinho('Heniken', 9.00)">Heniken</button>
                    </div>
                    <div class="categoria_pratos" style="display: grid; margin-left: 8px;">
                        <h2> AGUÁ </h2>
                        <button type="button" onclick="adicionarAoCarrinho('Aguá sem gás', 3.00)">Aguá se gás</button>
                        <button type="button" onclick="adicionarAoCarrinho('Aguá sem gás', 4.00)">Aguá sem gás</button>
                    </div>
                    <div class="categoria_pratos" style="display: grid; margin-left: 8px;">
                        <h2> SUCOS </h2>
                        <button type="button" onclick="adicionarAoCarrinho('Suco de uva Delvale lata', 7.00)">Suco de uva Delvale lata</button>
                    </div>
                </div>
            </div>
            <div class="div_nov_ped" align='center' style="overflow-y: auto; height: 100vh;">
                <div align="center">
                    <h2>Carrinho:</h2>
                </div>
                <input type="hidden" name="carrinho_lista" id="carrinho_hidden">
                <input type="hidden" name="itens" id="itens_hidden"><div id="carrinho_lista"></div>
                <button type="button" onclick="limparCarrinho()" >Limpar Carrinho</button>
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
                                <td class="td_pedido"><input type="text" name="obs_entrega" id="obs_entrega" style="font-size: 20px;"></td>
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
                                    <select style="height: 7vh" class="select" name="form_pag" id="form_pag" >
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