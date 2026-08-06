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
                <div class="div_nov_ped">
                    <h1 align="center">Produtos:</h1>
                    <div>
                        <div class="menu">
                            <div>
                                <div class="container-produtos">
                                    <?php
                                        // Array contendo todos os produtos
                                        $itens = array(
                                            
                                            // Produto 1
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 2
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 3
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 4
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 5
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 6
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 7
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 8
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 9
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 10
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 11
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 12
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 13
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 14
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],

                                            // Produto 15
                                            ['nome' => '', 'imagem' => '', 'preco' => 0.00],
                                        );

                                        // foreach percorre todos os produtos do array
                                        foreach($itens as $key => $value){
                                    ?>
                                            <!-- Caixa do produto -->
                                            <div class="produto">

                                                <!-- Imagem do produto -->
                                                <img src="<?php echo $value['imagem']; ?>" style="height: 150px;"><br><br>

                                                <!-- Nome do produto -->
                                                <strong><?php echo $value['nome']; ?></strong><br>

                                                <!-- Mostra o preço formatado -->
                                                R$ <?php echo number_format($value['preco'],2,',','.'); ?><br><br>

                                                <!-- Link para adicionar produto -->
                                                <!-- O valor do produto vai pela URL -->
                                                <a href="?adicionar=<?php echo $key; ?>">
                                                    Adicionar ao Carrinho
                                                </a>
                                            </div>
                                            <?php 
                                        } 
                                            ?>
                                </div>
                                <?php
                                    // Verifica se existe "adicionar" na URL
                                    if(isset($_GET['adicionar'])){
                                        // Converte o valor recebido para inteiro
                                        $idProduto = (int) $_GET['adicionar'];

                                        // Verifica se o produto existe no array
                                        if(isset($itens[$idProduto])){
                                            // Verifica se o produto já está no carrinho
                                            if(isset($_SESSION['carrinho'][$idProduto])){
                                                // Soma +1 na quantidade
                                                $_SESSION['carrinho'][$idProduto]['quantidade']++;
                                            }else{
                                                // Cria um novo produto no carrinho
                                                $_SESSION['carrinho'][$idProduto] = array(
                                                    // Quantidade inicial
                                                    'quantidade' => 1,

                                                    // Nome do produto
                                                    'nome' => $itens[$idProduto]['nome'],

                                                    // Preço do produto
                                                    'preco' => $itens[$idProduto]['preco']
                                                );
                                            }

                                // Exibe mensagem na tela
                                echo '<script>alert("Produto adicionado ao carrinho!");</script>';

                                        }else{
                                            // Caso tentem adicionar um produto inexistente
                                            die("Você não pode adicionar um produto que não existe.");
                                        }
                                    }

                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="div_nov_ped">
                    <h1 align="center">Carrinho:</h1>
                            <div id="carrinho" style="display: flex; justify-content: space-between;">
                                <div style="margin-left: 50px; height: 100%; width: 40%; border-radius: 10px; background-color: white;">
                                    <?php 
                                        echo "<h2 style='margin-left: 10px'>Carrinho:</h2>";
                                        if(isset($_GET['adicionar']))
                                            {
                                                // Converte o valor recebido para inteiro
                                                $idProduto = (int) $_GET['adicionar'];

                                                // Verifica se o produto existe no array
                                                if(isset($itens[$idProduto]))
                                                    {
                                                        // Verifica se o produto já está no carrinho
                                                        if(isset($_SESSION['carrinho'][$idProduto]))
                                                            {
                                                                // Soma +1 na quantidade
                                                                $_SESSION['carrinho'][$idProduto]['quantidade']++;
                                                            }
                                                        else
                                                            {
                                                                // Cria um novo produto no carrinho
                                                                $_SESSION['carrinho'][$idProduto] = array(

                                                                // Quantidade inicial
                                                                'quantidade' => 1,

                                                                // Nome do produto
                                                                'nome' => $itens[$idProduto]['nome'],

                                                                // Preço do produto
                                                                'preco' => $itens[$idProduto]['preco']


                                                                );
                                                            }
                                                    }
                                            }
                                        // DIMINUIR QUANTIDADE
                                        if(isset($_GET['diminuir'])) {
                                            $idProduto = (int) $_GET['diminuir'];

                                            if(isset($_SESSION['carrinho'][$idProduto])) {
                                                // Diminui 1
                                                $_SESSION['carrinho'][$idProduto]['quantidade']--;

                                                // Se chegar a 0, remove o produto do carrinho
                                                if($_SESSION['carrinho'][$idProduto]['quantidade'] <= 0) {
                                                    unset($_SESSION['carrinho'][$idProduto]);
                                                }
                                            }
                                        }
                                        // AUMENTAR QUANTIDADE
                                        if(isset($_GET['aumentar'])) {
                                            $idProduto = (int) $_GET['aumentar'];

                                            if(isset($_SESSION['carrinho'][$idProduto])) {
                                                $_SESSION['carrinho'][$idProduto]['quantidade']++;
                                            }
                                        }
                                        if(isset($_SESSION['carrinho']))
                                            {
                                                // Variável para guardar total
                                                $total = 0;

                                                // Percorre todos os produtos do carrinho
                                                foreach($_SESSION['carrinho'] as $key => $value)
                                                    {
                                                        // Multiplica quantidade pelo preço
                                                        $subtotal = $value['quantidade'] * $value['preco'];

                                                        // Soma no total geral
                                                        $total += $subtotal;

                                                        if(isset($_GET['remover'])) {
                                                            $idProduto = (int) $_GET['remover'];

                                                            if(isset($_SESSION['carrinho'][$idProduto])) {
                                                                unset($_SESSION['carrinho'][$idProduto]);
                                                            }
                                                        }

                                                        if(isset($_GET['limpar'])) {
                                                            unset($_SESSION['carrinho']);
                                                        }

                                                        // Mostra os dados do produto
                                                        echo '<p style="margin-left: 10px; width: 90%;">'.'
                                                            Nome: '.$value['nome'].' <br>
                                                            Quantidade: '.$value['quantidade'].' 
                                                            <button style="margin-left: 20px;" onclick="tirar1('.$key.'), location.reload();">-</button>
                                                            <button style="margin-left: 5px;" onclick="adicionar1('.$key.'), location.reload();">+</button>
                                                            <button style="margin-left: 20px;" onclick="apagaProduto('.$key.'), location.reload();">Retirar do carrinho</button> <br>
                                                            Preço: R$ '.number_format($subtotal,2,',','.').'
                                                            </p>';

                                                    }

                                                // Mostra o valor total do carrinho
                                                echo "<h3 style='margin-left: 10px'>Total: R$ ".number_format($total,2,',','.')."</h3>";

                                                echo "<button style='margin-left: 40px; margin-bottom: 10px; font-size: 18px; width: 90%;' onclick='limparCarrinho(), location.reload();'> Limpar Carrinho </button>";
                                            }
                                        else
                                            {
                                                // Caso não exista nenhum produto
                                                echo "<div align='center'>Carrinho vazio.</div>";
                                            }    
                                        ?>
                                </div>
                                <div style="margin-right: 50px;height: 100%; width: 40%; border-radius: 10px; background-color: white;">
                                    <h1 align="center">
                                        Resumo da Compra
                                    </h1>
                                    <div align="center" style="font-size: 20px;">
                                        -------------------------------------------------------------------
                                    </div>
                                    <?php
                                    if(isset($_SESSION['carrinho']))
                                            {
                                                // Variável para guardar total
                                                $total = 0;

                                                // Percorre todos os produtos do carrinho
                                                foreach($_SESSION['carrinho'] as $key => $value)
                                                    {
                                                        // Multiplica quantidade pelo preço
                                                        $subtotal = $value['quantidade'] * $value['preco'];

                                                        // Soma no total geral
                                                        $total += $subtotal;
                                                    }
                                                // Mostra o endereço
                                                echo '<p style="margin-left: 20px;"> Endereço: '. '</p>';

                                                // Mostra a taxa de entrega
                                                echo '<p style="margin-left: 20px;"> Taxa de entrega: '. '</p>';
                                                
                                                // Mostra o valor total do carrinho
                                                echo "<h3 style='margin-left: 20px;'>Total: R$ ".number_format($total,2,',','.')."</h3>";

                                                if(isset($_GET['limpar'])) {
                                                        unset($_SESSION['carrinho']);
                                                    }

                                                echo '<button style="margin-left: 40px; margin-bottom: 10px; font-size: 18px; width: 90%;"> comprar </button>';
                                            }
                                        else
                                            {
                                                // Caso não exista nenhum produto
                                                echo "<div align='center'>Carrinho vazio.</div>";
                                            }    
                                        ?>
                                </div>
                            </div>
                        </div>
                        <script>
                            function apagaProduto(id) {
                                window.location.href = "?remover=" + id;
                            }
                            function limparCarrinho() {
                                window.location.href = "?limpar=1";
                            }
                            function tirar1(id) {
                                window.location.href = "?diminuir=" + id;
                            }
                            function adicionar1(id) {
                                window.location.href = "?aumentar=" + id;
                            }
                    </script>
                <div class="div_nov_ped">
                    <div id="div_dados" class="tabela"> 
                        <div>
                            <form method="POST" action="cadastro_venda.php" id="formulario"  onsubmit="atualizarTotalBanco()">
                            <table  align="center">
                                <tr>
                                    <td colspan="2" style="text-align: center;"><h2>Dados do cliente:</h2></td>
                                </tr>
                                <tr>
                                    <td class="td_pedido">Telefone:</td>
                                    <td class="td_pedido"><input type="text" name="telefone" id="telefone" required></td>
                                </tr>
                                <tr>
                                    <td class="td_pedido">Nome:</td>
                                    <td class="td_pedido"><input type="text" name="nome" id="nome" required></td>
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
                                    <td class="td_pedido">Rua:</td>
                                    <td class="td_pedido"><input type="text" name="rua" id="rua"></td>
                                </tr>
                                <tr>
                                    <td class="td_pedido">Número:</td>
                                    <td class="td_pedido"><input type="number" name="numero" id="numero"></td>
                                </tr>
                                <tr>
                                    <td class="td_pedido">Bairro:</td>
                                    <td class="td_pedido">
                                        <select name="bairro" id="bairro">

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td_pedido">Observação:</td>
                                    <td class="td_pedido"><input type="text" name="obs" id="obs" ></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tabela">
                        <div id="div_form_pag">
                            <table  align="center">
                                <tr>
                                    <td colspan="2"><h2>Valor do pedido:</h2></td>
                                    <input type="hidden" name="valor" id="valor">
                                </tr>
                                <tr>
                                    <td class="td_pedido">Total:</td>
                                    <td class="td_pedido" id="total_pedido" name="total_pedido"></td>
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
                                    <td class="td_pedido"><input type="text" name="obs_pag" id="obs_pag"></td>  
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <button type="submit" style="background-color: #990000ab; color: white; border: none; padding: 10px 20px; cursor: pointer;">Cadastrar Pedido</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <script src="entrega.js"></script>
    <script src="script.js"></script>
</body>
</html>