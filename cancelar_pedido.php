
<?php

session_start();
require_once 'conexao.php';

// Verificar se o ID foi enviado
$id_venda = filter_input(
    INPUT_POST,
    'id_venda',
    FILTER_VALIDATE_INT
);

if (!$id_venda) {
    exit('ID do pedido inválido.');
}

mysqli_begin_transaction($conexao);

try {

    // ==========================================
    // 1. EXCLUIR OS ITENS DA VENDA
    // ==========================================

    $sqlItens = "
        DELETE FROM itens_venda
        WHERE id_venda = ?
    ";

    $stmtItens = mysqli_prepare($conexao, $sqlItens);

    if (!$stmtItens) {
        throw new Exception('Erro ao preparar a exclusão dos itens.');
    }

    mysqli_stmt_bind_param(
        $stmtItens,
        'i',
        $id_venda
    );

    if (!mysqli_stmt_execute($stmtItens)) {
        mysqli_stmt_close($stmtItens);
        throw new Exception('Erro ao excluir os itens do pedido.');
    }

    mysqli_stmt_close($stmtItens);

    // ==========================================
    // 2. EXCLUIR A VENDA
    // ==========================================

    $sqlVenda = "
        DELETE FROM vendas
        WHERE id_venda = ?
    ";

    $stmtVenda = mysqli_prepare($conexao, $sqlVenda);

    if (!$stmtVenda) {
        throw new Exception('Erro ao preparar a exclusão da venda.');
    }

    mysqli_stmt_bind_param(
        $stmtVenda,
        'i',
        $id_venda
    );

    if (!mysqli_stmt_execute($stmtVenda)) {
        mysqli_stmt_close($stmtVenda);
        throw new Exception('Erro ao excluir a venda.');
    }

    $linhasAfetadas = mysqli_stmt_affected_rows($stmtVenda);

    mysqli_stmt_close($stmtVenda);

    if ($linhasAfetadas === 0) {
        throw new Exception('Pedido não encontrado.');
    }

    // ==========================================
    // 3. CONFIRMAR AS EXCLUSÕES
    // ==========================================

    mysqli_commit($conexao);

    // Remover a comanda da sessão, se existir
    unset($_SESSION['comandas'][$id_venda]);

    // Voltar para a lista de pedidos
    header('Location: ver_pedidos.php?cancelado=1');
    exit;

} catch (Throwable $e) {

    mysqli_rollback($conexao);

    http_response_code(500);

    echo 'Não foi possível cancelar o pedido: ' .
        htmlspecialchars(
            $e->getMessage(),
            ENT_QUOTES,
            'UTF-8'
        );
}
