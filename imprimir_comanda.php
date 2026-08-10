<?php
    require('conexao.php');

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $carrinho = $_POST['carrinho_lista'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $obs_entrega = $_POST['obs_entrega'];
    $total = $_POST['total'];
    $forma_pagamento = $_POST['form_pag'];
    $obs_pagamento = $_POST['obs_pagamento'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $rua = $_POST['rua'] ?? null;
        $numero = $_POST['numero'] ?? null;
        $bairro = $_POST['bairro'] ?? null;
        $total = $_POST['total'];
        $forma_pagamento = $_POST['form_pag'];
        $obs_pagamento = $_POST['obs_pagamento'];
        $tipo_entrega = $_POST['tipo_entrega'];

        // 🔎 VERIFICA SE CLIENTE JÁ EXISTE PELO TELEFONE
        $sqlBusca = "SELECT id_cliente FROM clientes WHERE telefone = ?";
        $stmtBusca = mysqli_prepare($conexao, $sqlBusca);
        mysqli_stmt_bind_param($stmtBusca, "s", $telefone);
        mysqli_stmt_execute($stmtBusca);
        $resultado = mysqli_stmt_get_result($stmtBusca);

        if ($row = mysqli_fetch_assoc($resultado)) {
            // ✅ Cliente já existe
            $id_cliente = $row['id_cliente'];
        } else {
            // 🆕 Cria novo cliente
            $sql = "INSERT INTO clientes (nome, telefone) VALUES (?, ?)";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $nome, $telefone);
            mysqli_stmt_execute($stmt);

            $id_cliente = mysqli_insert_id($conexao);
        }

        // 📍 ENDEREÇO (SE FOR ENTREGA)
        if ($tipo_entrega === "entregar") {

            $sqlEndereco = "INSERT INTO enderecos_cliente 
            (id_cliente, rua, numero, bairro) 
            VALUES (?, ?, ?, ?)";

            $stmtEndereco = mysqli_prepare($conexao, $sqlEndereco);
            mysqli_stmt_bind_param($stmtEndereco, "isss", 
                $id_cliente, $rua, $numero, $bairro
            );

            mysqli_stmt_execute($stmtEndereco);

            $id_endereco_cliente = mysqli_insert_id($conexao);

        } else {
            // 🛍️ Retirada
            $tipo_entrega = "retirada";
            $id_endereco_cliente = null;
        }

        // 🧾 INSERE VENDA
        $sqlVenda = "INSERT INTO vendas 
        (id_cliente, id_endereco_cliente, total, forma_pagamento, obs_pagamento, tipo_entrega) 
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmtVenda = mysqli_prepare($conexao, $sqlVenda);

        mysqli_stmt_bind_param($stmtVenda, "iidsss",
            $id_cliente,
            $id_endereco_cliente,
            $total,
            $forma_pagamento,
            $obs_pagamento,
            $tipo_entrega
        );

        mysqli_stmt_execute($stmtVenda);
    }
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
                
            </tr>
            <tr>
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
                <td><?php echo $obs_entrega; ?></td>
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