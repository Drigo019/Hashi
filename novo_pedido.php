<?php
session_start();

if (empty($_SESSION['token_pedido'])) {
    $_SESSION['token_pedido'] = bin2hex(random_bytes(32));
}

$conn = new mysqli("localhost", "root", "", "hashi");

if ($conn->connect_error) {
    die("Erro na conexão com o banco: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// =====================================================
// BUSCAR PRODUTOS
// =====================================================

$sql = "SELECT id_produto, nome, valor, categoria FROM produtos ORDER BY nome ASC";
$resultado = $conn->query($sql);

if (!$resultado) {
    die("Erro na consulta: " . $conn->error);
}

// =====================================================
// CATEGORIAS
// =====================================================

$categorias = [
    'prato quente' => 'Pratos Quentes',
    'entrada' => 'Entradas',
    'poke' => 'Pokes',
    'temaki' => 'Temakis',
    'hot roll' => 'Hot Roll',
    'hossomaki' => 'Hossomaki',
    'uramaki' => 'Uramaki',
    'especial' => 'Especiais',
    'combinado' => 'Combinados',
    'sobremesa' => 'Sobremesas',
    'refrigerante' => 'Refrigerantes',
    'cerveja' => 'Cervejas',
    'agua' => 'Águas',
    'suco' => 'Sucos',
    'promocao' => 'Promoção'
];

// =====================================================
// SEPARAR PRODUTOS POR CATEGORIA
// =====================================================

$produtosPorCategoria = [];

foreach ($categorias as $categoria => $titulo) {
    $produtosPorCategoria[$categoria] = [];
}

while ($produto = $resultado->fetch_assoc()) {
    $categoria = $produto['categoria'];

    if (isset($produtosPorCategoria[$categoria])) {
        $produtosPorCategoria[$categoria][] = $produto;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Pedido</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icons/logo.png">
</head>

<body class="body">

    <div style="display: flex;">

        <!-- =====================================================
         MENU LATERAL
    ====================================================== -->

        <div style="display: flex;">

            <div id="menu">

                <div id="inicio" align="center">
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

                <div align="center">
                    <button class="btn" onclick="window.location.href='ver_pedidos.php'">
                        <img class="icons_menu" src="icons/pedido.png">
                        <div style="font-size: 18px;">Ver Pedidos</div>
                    </button>
                </div>

                <div align="center">
                    <button class="btn" onclick="window.location.href='produtos.php'">
                        <img class="icons_menu" src="icons/prato.png">
                        <div style="font-size: 18px;">Pratos</div>
                    </button>
                </div>

                <div align="center">
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

        <!-- =====================================================
         FORMULÁRIO DO PEDIDO
    ====================================================== -->

        <form action="imprimir_comanda.php" method="POST"
            onsubmit="return prepararEnvio()"
            style="display: flex; width: 90%; height: 100vh;">

            <input type="hidden" name="token_pedido"
                value="<?= htmlspecialchars($_SESSION['token_pedido'], ENT_QUOTES, 'UTF-8') ?>">

            <!-- =====================================================
             PRODUTOS
        ====================================================== -->

            <div class="div_nov_ped" align="center"
                style="overflow-y: auto; height: 100vh;">

                <?php foreach ($categorias as $categoria => $titulo) { ?>

                    <div style="border: 1px solid; margin-top: 8px;">

                        <div class="categoria">

                            <h2>
                                <?= htmlspecialchars($titulo) ?>:
                            </h2>

                            <div class="carrinho_container">

                                <?php if (!empty($produtosPorCategoria[$categoria])) { ?>

                                    <?php foreach ($produtosPorCategoria[$categoria] as $produto) { ?>

                                        <div class="produto">

                                            <strong>
                                                <?= htmlspecialchars($produto['nome']) ?>
                                            </strong>

                                            <br>

                                            R$
                                            <?= number_format($produto['valor'], 2, ',', '.') ?>

                                            <br>

                                            <button type="button"
                                                class="btn_adicionar"
                                                onclick='abrir_popup_produto(
                                                <?= (int)$produto["id_produto"] ?>,
                                                <?= json_encode($produto["nome"], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP) ?>,
                                                <?= json_encode((float)$produto["valor"]) ?>
                                            )'>

                                                Adicionar

                                            </button>

                                        </div>

                                    <?php } ?>

                                <?php } else { ?>

                                    <div style="width: 100%; padding: 20px;">
                                        Nenhum produto cadastrado.
                                    </div>

                                <?php } ?>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

            <!-- =====================================================
             CARRINHO
        ====================================================== -->

            <div class="div_nov_ped" align="center"
                style="overflow-y: auto; height: 100vh;">

                <div align="center">
                    <h2>Carrinho:</h2>
                </div>

                <input type="hidden" name="carrinho_lista" id="carrinho_hidden">

                <input type="hidden" name="itens" id="itens_hidden">

                <div id="carrinho_lista"></div>

                <button type="button" onclick="limparCarrinho()">
                    Limpar Carrinho
                </button>

            </div>

            <!-- =====================================================
             DADOS DO CLIENTE
        ====================================================== -->

            <div class="div_nov_ped" id="comanda">

                <div id="div_dados" class="tabela">

                    <table align="center">

                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <h2>Dados do cliente:</h2>
                            </td>
                        </tr>

                        <tr>
                            <td class="td_pedido">Telefone:</td>

                            <td class="td_pedido">

                                <input type="text"
                                    name="telefone"
                                    autocomplete="off"
                                    id="telefone"
                                    style="font-size: 20px;"
                                    required>

                                <div id="lista_clientes"></div>

                            </td>
                        </tr>

                        <tr>
                            <td class="td_pedido">Nome:</td>

                            <td class="td_pedido">
                                <input type="text"
                                    name="nome"
                                    id="nome"
                                    style="font-size: 20px;"
                                    required>
                            </td>
                        </tr>

                    </table>

                </div>

                <!-- =====================================================
                 ENTREGA
            ====================================================== -->

                <div id="div_entrega" class="tabela">

                    <table align="center">

                        <tr>
                            <td colspan="2">
                                <h2>Envio do pedido:</h2>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="td_pedido">

                                <select class="select"
                                    name="tipo_entrega"
                                    id="tipo_entrega"
                                    onchange="atualizar_entrega()">

                                    <option value="retirada" selected>Retirada</option>
                                    <option value="entregar">Entregar</option>

                                </select>

                            </td>
                        </tr>

                    </table>

                    <table align="center" id="endereco" style="display: none;">

                        <tr>
                            <td class="td_pedido">Rua:</td>

                            <td class="td_pedido">
                                <input type="text" name="rua" id="rua"
                                    style="font-size: 20px;">
                            </td>
                        </tr>

                        <tr>
                            <td class="td_pedido">Número:</td>

                            <td class="td_pedido">
                                <input type="number" name="numero" id="numero"
                                    style="font-size: 20px;">
                            </td>
                        </tr>

                        <tr>
                            <td class="td_pedido">Bairro:</td>

                            <td class="td_pedido">

                                <select name="bairro" id="bairro" style="height: 100%;">

                                    <option value="">Selecione</option>
                                    <option value="Alcebiades Quilice">Alcebiades Quilice</option>
                                    <option value="Alto do Vale II">Alto do Vale II</option>
                                    <option value="Altos do vale">Altos do Vale</option>
                                    <option value="Alvorada">Alvorada</option>
                                    <option value="Anita Venturi Pricoli">Anita Venturi Pricoli</option>
                                    <option value="Aparecida">Aparecida</option>
                                    <option value="Área Rural de Mococa">Área Rural de Mococa</option>
                                    <option value="Ari Estevão">Ari Estevão</option>
                                    <option value="Barra Feita">Barra Feita</option>
                                    <option value="Bela Vista">Bela Vista</option>
                                    <option value="Bianchesi">Bianchesi</option>
                                    <option value="Botânico">Botânico</option>
                                    <option value="Brás">Brás</option>
                                    <option value="Carlito Quilici">Carlito Quilici</option>
                                    <option value="Cecap I">Cecap I</option>
                                    <option value="Cecap II">Cecap II</option>
                                    <option value="Central Prícoli">Central Prícoli</option>
                                    <option value="Centro">Centro</option>
                                    <option value="Chácara do Vale">Chácara do Vale</option>
                                    <option value="Chácarados Ipês">Chácara dos Ipês</option>
                                    <option value="Chico Piscina">Chico Piscina</option>
                                    <option value="Colina Verde">Colina Verde</option>
                                    <option value="Cohab I">Cohab I</option>
                                    <option value="Cohab II">Cohab II</option>
                                    <option value="Descanso">Descanso</option>
                                    <option value="Distrito Industrial I">Distrito Industrial I</option>
                                    <option value="Distrito Industrial II">Distrito Industrial II</option>
                                    <option value="Figueiras">Figueiras</option>
                                    <option value="Flaboyans">Flaboyans</option>
                                    <option value="Francisco Garófalo">Francisco Garófalo</option>
                                    <option value="Gabriel do Ó">Gabriel do Ó</option>
                                    <option value="Gatolândia">Gatolândia</option>
                                    <option value="Gilberto Rossetti">Gilberto Rossetti</option>
                                    <option value="Gildo Geraldo">Gildo Geraldo</option>
                                    <option value="Imperador">Imperador</option>
                                    <option value="Itálico Maziero">Itálico Maziero</option>
                                    <option value="Jardim Itália">Jardim Itália</option>
                                    <option value="José André de Lima">José André de Lima</option>
                                    <option value="José Justi">José Justi</option>
                                    <option value="José Justi II">José Justi II</option>
                                    <option value="Lago azul">Lago Azul</option>
                                    <option value="Lago dos Ipês">Lago dos Ipês</option>
                                    <option value="Lavínia">Lavínia</option>
                                    <option value="Luiz Fernandes Dias">Luiz Fernandes Dias</option>
                                    <option value="Mais parque">Mais Parque</option>
                                    <option value="Maziero">Maziero</option>
                                    <option value="Miguel Gomes">Miguel Gomes</option>
                                    <option value="Mocoquinha">Mocoquinha</option>
                                    <option value="Monte Belo">Monte Belo</option>
                                    <option value="Morro Azul">Morro Azul</option>
                                    <option value="Nelson Niero">Nelson Niero</option>
                                    <option value="Nenê Pereira Lima">Nenê Pereira Lima</option>
                                    <option value="Nova Mococa">Nova Mococa</option>
                                    <option value="Paineira">Paineira</option>
                                    <option value="Palmeirinha">Palmeirinha</option>
                                    <option value="Parque das Canoas">Parque das Canoas</option>
                                    <option value="Parque dos Manacás I">Parque dos Manacás</option>
                                    <option value="Planalto Verde">Planalto Verde</option>
                                    <option value="Portal da Cidade">Portal da Cidade</option>
                                    <option value="Pôr do Sol">Pôr do Sol</option>
                                    <option value="Primavera">Primavera</option>
                                    <option value="Progresso">Progresso</option>
                                    <option value="Residencil do Bosque">Residencial do Bosque</option>
                                    <option value="Riachuelo">Riachuelo</option>
                                    <option value="Riachuelo II">Riachuelo II</option>
                                    <option value="Rigobelo">Rigobelo</option>
                                    <option value="Samanbaia">Samambaia</option>
                                    <option value="Santa Cecília">Santa Cecília</option>
                                    <option value="Santa Clara">Santa Clara</option>
                                    <option value="Santa Emília">Santa Emília</option>
                                    <option value="Santa Helena">Santa Helena</option>
                                    <option value="Santa Luzia">Santa Luzia</option>
                                    <option value="Santa Maria">Santa Maria</option>
                                    <option value="Santa Terezinha I">Santa Terezinha I</option>
                                    <option value="Santa Terezinha II">Santa Terezinha II</option>
                                    <option value="São Benedito">São Benedito</option>
                                    <option value="São Domingos">São Domingos</option>
                                    <option value="São Francisco">São Francisco</option>
                                    <option value="São José">São José</option>
                                    <option value="São Luiz">São Luiz</option>
                                    <option value="São Pelegrino">São Pelegrino</option>
                                    <option value="Terras de Santa Marina">Terras de Santa Marina</option>
                                    <option value="Vale Verde">Vale Verde</option>
                                    <option value="Vila Carvalho">Vila Carvalho</option>
                                    <option value="Vila Lambari">Vila Lambari</option>
                                    <option value="Vila Maria">Vila Maria</option>
                                    <option value="Vila Mariana">Vila Mariana</option>
                                    <option value="Vila Naufel">Vila Naufel</option>
                                    <option value="Vila Quintino">Vila Quintino</option>
                                    <option value="Vila Santa Cruz">Vila Santa Cruz</option>
                                    <option value="Vila Santa Rosa">Vila Santa Rosa</option>

                                </select>

                            </td>
                        </tr>

                        <tr>
                            <td class="td_pedido">Observação:</td>

                            <td class="td_pedido">
                                <input type="text" name="obs_entrega" id="obs_entrega"
                                    style="font-size: 20px;">
                            </td>
                        </tr>

                    </table>

                </div>

                <!-- =====================================================
                 PAGAMENTO
            ====================================================== -->

                <div class="tabela">

                    <div id="div_form_pag">

                        <table align="center">

                            <tr>

                                <td class="td_pedido">
                                    Total: R$
                                </td>

                                <td class="td_pedido">

                                    <input type="text" id="total_visivel"
                                        style="font-size: 20px;" readonly>

                                    <input type="hidden" name="total" id="total_hidden">

                                </td>

                            </tr>

                            <tr>

                                <td class="td_pedido">
                                    Forma de pagamento:
                                </td>

                                <td class="td_pedido">

                                    <select style="height: 7vh"
                                        class="select"
                                        name="form_pag"
                                        id="form_pag">

                                        <option value="dinheiro">Dinheiro</option>
                                        <option value="cartao">Cartão</option>
                                        <option value="pix">Pix</option>
                                        <option value="ifood">Ifood</option>
                                        <option value="fiado">Fiado</option>

                                    </select>

                                </td>

                            </tr>

                            <tr>

                                <td class="td_pedido">
                                    Observação:
                                </td>

                                <td class="td_pedido">

                                    <input type="text"
                                        name="obs_pagamento"
                                        id="obs_pagamento"
                                        style="font-size: 20px;">

                                </td>

                            </tr>

                            <tr>

                                <td colspan="2" style="text-align: center;">

                                    <button type="submit"
                                        style="background-color: #990000ab; color: white; border: none; padding: 10px 20px; cursor: pointer;">

                                        Imprimir Comanda

                                    </button>

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </form>

    </div>

    <!-- =====================================================
     POPUP DO PRODUTO
====================================================== -->

    <div id="produto" class="modal_fundo">

        <div class="modal">

            <button type="button" class="btn_fechar"
                onclick="fechar_popup_produto()">
                ×
            </button>

            <table border="1" align="center">

                <tr>
                    <td>Nome:</td>
                    <td id="nome_produto"></td>
                </tr>

                <tr>
                    <td>Valor:</td>
                    <td id="valor_produto"></td>
                </tr>

                <tr>
                    <td>Quantidade:</td>

                    <td>
                        <input type="number" id="quantidade"
                            value="1" min="1">
                    </td>
                </tr>

                <tr>
                    <td>Obs:</td>

                    <td>
                        <input type="text" id="obs_produto"
                            placeholder="Observação do produto">
                    </td>
                </tr>

                <tr>

                    <td colspan="2" style="text-align: center;">

                        <button type="button"
                            class="btn_adicionar"
                            onclick="confirmarAdicao()">

                            Adicionar

                        </button>

                    </td>

                </tr>

            </table>

        </div>

    </div>

    <script src="script.js"></script>

    <script>
        // =====================================================
        // CARRINHO
        // =====================================================

        let carrinho = [];

        let produtoSelecionado = null;

        // =====================================================
        // ABRIR POPUP
        // =====================================================

        function abrir_popup_produto(id_produto, nome, valor) {

            produtoSelecionado = {
                id_produto: Number(id_produto),
                nome: nome,
                valor: Number(valor)
            };

            document.getElementById("produto").style.display = "flex";

            document.getElementById("nome_produto").textContent = nome;

            document.getElementById("valor_produto").textContent =
                valor.toFixed(2);

            document.getElementById("quantidade").value = 1;

            document.getElementById("obs_produto").value = "";

        }

        // =====================================================
        // FECHAR POPUP
        // =====================================================

        function fechar_popup_produto() {

            document.getElementById("produto").style.display = "none";

            produtoSelecionado = null;

        }

        // =====================================================
        // CONFIRMAR ADIÇÃO
        // =====================================================

        function confirmarAdicao() {

            if (!produtoSelecionado) {
                alert("Selecione um produto.");
                return;
            }

            const quantidade = parseInt(
                document.getElementById("quantidade").value
            );

            const observacao = document.getElementById("obs_produto").value.trim();

            if (isNaN(quantidade) || quantidade < 1) {
                alert("Informe uma quantidade válida.");
                return;
            }

            adicionarAoCarrinho(
                produtoSelecionado.id_produto,
                produtoSelecionado.nome,
                produtoSelecionado.valor,
                quantidade,
                observacao
            );

            fechar_popup_produto();

        }

        // =====================================================
        // ADICIONAR AO CARRINHO
        // =====================================================

        function adicionarAoCarrinho(id_produto, nome, preco, quantidade = 1, observacao = "") {

            // Procura produto com mesmo ID e mesma observação
            let itemExistente = carrinho.find(item =>
                item.id_produto === Number(id_produto) &&
                item.obs_produto === observacao
            );

            if (itemExistente) {

                itemExistente.qtd += quantidade;

            } else {

                carrinho.push({

                    id_produto: Number(id_produto),
                    nome: nome,
                    preco: Number(preco),
                    qtd: quantidade,
                    obs_produto: observacao

                });

            }

            atualizarCarrinho();

        }

        // =====================================================
        // REMOVER ITEM
        // =====================================================

        function removerItem(index) {

            carrinho.splice(index, 1);

            atualizarCarrinho();

        }

        // =====================================================
        // LIMPAR CARRINHO
        // =====================================================

        function limparCarrinho() {

            carrinho = [];

            atualizarCarrinho();

        }

        // =====================================================
        // ATUALIZAR CARRINHO
        // =====================================================

        function atualizarCarrinho() {

            const lista = document.getElementById("carrinho_lista");

            lista.innerHTML = "";

            let total = 0;

            carrinho.forEach((item, index) => {

                const div = document.createElement("div");

                const subtotal = item.preco * item.qtd;

                total += subtotal;

                const texto = document.createElement("span");

                texto.textContent =
                    `${item.nome} (x${item.qtd}) - R$ ${subtotal.toFixed(2)}`;

                div.appendChild(texto);

                // Observação individual
                if (item.obs_produto !== "") {

                    const observacao = document.createElement("div");

                    observacao.textContent =
                        "Obs: " + item.obs_produto;

                    div.appendChild(observacao);

                }

                const botao = document.createElement("button");

                botao.type = "button";

                botao.textContent = "❌";

                botao.style.height = "35px";

                botao.style.width = "35px";

                botao.addEventListener("click", () => removerItem(index));

                div.appendChild(botao);

                lista.appendChild(div);

            });

            document.getElementById("total_visivel").value =
                total.toFixed(2);

            document.getElementById("total_hidden").value =
                total.toFixed(2);

        }

        // =====================================================
        // PREPARAR ENVIO DO PEDIDO
        // =====================================================

        function prepararEnvio() {

            if (carrinho.length === 0) {

                alert("Adicione pelo menos um produto ao pedido.");

                return false;

            }

            // Texto da comanda
            const listaTexto = carrinho.map(item => {

                const subtotal = item.preco * item.qtd;

                let texto =
                    `${item.nome} (x${item.qtd}) - R$ ${subtotal.toFixed(2)}`;

                if (item.obs_produto !== "") {

                    texto += ` | Obs: ${item.obs_produto}`;

                }

                return texto;

            }).join("<br>");

            // Produtos que serão enviados ao PHP
            const itens = carrinho.map(item => ({

                id_produto: item.id_produto,

                qtd: item.qtd,

                obs_produto: item.obs_produto

            }));

            document.getElementById("carrinho_hidden").value = listaTexto;

            document.getElementById("itens_hidden").value =
                JSON.stringify(itens);

            return true;

        }

        // =====================================================
        // BUSCAR CLIENTES PELO TELEFONE
        // =====================================================

        const campoTelefoneCliente = document.getElementById("telefone");

        const listaClientesBusca = document.getElementById("lista_clientes");

        campoTelefoneCliente.addEventListener("input", function() {

            const valorTelefone = campoTelefoneCliente.value.trim();

            listaClientesBusca.innerHTML = "";

            if (valorTelefone.length < 3) {
                return;
            }

            fetch("buscar_clientes.php?telefone=" + encodeURIComponent(valorTelefone))

                .then(response => {

                    if (!response.ok) {
                        throw new Error("Erro na consulta.");
                    }

                    return response.json();

                })

                .then(clientes => {

                    listaClientesBusca.innerHTML = "";

                    if (!Array.isArray(clientes) || clientes.length === 0) {
                        return;
                    }

                    clientes.forEach(cliente => {

                        const opcaoCliente = document.createElement("div");

                        opcaoCliente.className = "opcao_cliente";

                        const nome = document.createElement("strong");

                        nome.textContent = cliente.nome;

                        const telefone = document.createElement("span");

                        telefone.textContent = cliente.telefone;

                        opcaoCliente.appendChild(nome);

                        opcaoCliente.appendChild(document.createElement("br"));

                        opcaoCliente.appendChild(telefone);

                        // Selecionar cliente
                        opcaoCliente.addEventListener("click", function() {

                            campoTelefoneCliente.value = cliente.telefone;

                            document.getElementById("nome").value =
                                cliente.nome || "";

                            document.getElementById("rua").value =
                                cliente.rua || "";

                            document.getElementById("numero").value =
                                cliente.numero || "";

                            document.getElementById("bairro").value =
                                cliente.bairro || "";

                            listaClientesBusca.innerHTML = "";

                        });

                        listaClientesBusca.appendChild(opcaoCliente);

                    });

                })

                .catch(erro => {

                    console.error("Erro ao buscar clientes:", erro);

                });

        });

        // =====================================================
        // ATUALIZAR ENTREGA
        // =====================================================

        function atualizar_entrega() {

            const tipoEntrega = document.getElementById("tipo_entrega").value;

            const endereco = document.getElementById("endereco");

            if (tipoEntrega === "entregar") {

                endereco.style.display = "table";

            } else {

                endereco.style.display = "none";

            }

        }

        // =====================================================
        // INICIALIZAR PÁGINA
        // =====================================================

        document.addEventListener("DOMContentLoaded", function() {

            atualizar_entrega();

            atualizarCarrinho();

        });
    </script>

</body>

</html>

<?php
$conn->close();
?>