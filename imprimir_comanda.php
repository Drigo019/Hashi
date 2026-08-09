<?php
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $carrinho = $_POST['carrinho_lista'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $obs_estrega = $_POST['obs_estrega'];
    $total = $_POST['total'];
    $forma_pagamento = $_POST['form_pag'];
    $obs_pagamento = $_POST['obs_pagamento'];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="comanda">
        <table style="height: auto; margin: 20px; margin-top: 0;">
            <tr>
                <td><strong>Nome:</strong></td>
                <td><?php echo $nome; ?></td>
            </tr>
            <tr>
                <td><strong>Telefone:</strong></td>
                <td><?php echo $telefone; ?></td>
            </tr>
            <tr>
                <td><strong>Pedido:</strong></td>
                <td><?php echo $carrinho; ?></td>
            </tr>
            <tr>
                <td><strong>rua:</strong></td>
                <td><?php echo $rua; ?></td>
            </tr>
            <tr>
                <td><strong>número:</strong></td>
                <td><?php echo $numero; ?></td>
            </tr>
            <tr>
                <td><strong>bairro:</strong></td>
                <td><?php echo $bairro; ?></td>
            </tr>
            <tr>
                <td><strong>Observação de Entrega:</strong></td>
                <td><?php echo $obs_estrega; ?></td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td><?php echo $total; ?></td>
            </tr>
            <tr>
                <td><strong>Forma de Pagamento:</strong></td>
                <td><?php echo $forma_pagamento; ?></td>
            </tr>
            <tr>
                <td><strong>Observação de Pagamento:</strong></td>
                <td><?php echo $obs_pagamento; ?></td>
            </tr>
        </table>
    </div>
    <script>
        // Chama a função ao carregar a página
        window.onload = function() {
            window.print();
        };
    </script>
    <style>
        @media print {

            /* remove tudo */
            body * {
                visibility: hidden;
            }

            /* mostra só a área que você quer */
            #comanda, #comanda * {
                visibility: visible;
            }

            /* cola no topo da página */
            #comanda {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            /* remove margens da página */
            @page {
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</body>
</html>