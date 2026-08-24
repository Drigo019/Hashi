
/*=================
    BOTÕES DE PERIODO 
=================*/
function alterarPeriodo(periodo) {

    window.location.href = "ver_pedidos.php?periodo=" + periodo;

}
function alternarDiv() {
    var menu = document.getElementById("menu");
    var imagem = document.getElementById("ico_menu");

    menu.classList.toggle("aberto");
    imagem.classList.toggle("girado");

    // Salva o estado do menu
    if (menu.classList.contains("aberto")) {
        localStorage.setItem("menuEstado", "aberto");
    } else {
        localStorage.setItem("menuEstado", "fechado");
    }
}


// Aplica o estado salvo ao carregar
window.addEventListener("load", function () {

    var menu = document.getElementById("menu");
    var imagem = document.getElementById("ico_menu");

    var estado = localStorage.getItem("menuEstado");

    if (estado === "aberto") {
        menu.classList.add("aberto");
        imagem.classList.add("girado");
    }

});


// ==============================
// CARRINHO
// ==============================

function atualizarCarrinho() {

    let lista = document.getElementById("carrinho_lista");

    if (!lista) {
        return;
    }

    lista.innerHTML = "";

    let total = 0;

    carrinho.forEach(function (item, index) {

        let div = document.createElement("div");

        let subtotal = item.preco * item.qtd;

        total += subtotal;

        div.innerHTML = `
            ${item.nome} (x${item.qtd}) - R$ ${subtotal.toFixed(2)}
            <button type="button" onclick="removerItem(${index})">
                ❌
            </button>
        `;

        lista.appendChild(div);

    });


    // Verifica o tipo de entrega
    let tipoEntrega = document.getElementById("tipo_entrega");

    if (tipoEntrega && tipoEntrega.value === "entregar") {

        total += 6.00;

    }


    // Mostra o total
    let totalVisivel = document.getElementById("total_visivel");

    if (totalVisivel) {

        totalVisivel.value = total
            .toFixed(2)
            .replace(".", ",");

    }


    // Envia o total para o PHP
    let totalHidden = document.getElementById("total_hidden");

    if (totalHidden) {

        totalHidden.value = total.toFixed(2);

    }

}


/* ==============================
    STATUS DOS PEDIDOS
============================== */ 

document.addEventListener("DOMContentLoaded", function () {

    const selects = document.querySelectorAll(".select_status");

    console.log("Quantidade de selects:", selects.length);


    selects.forEach(function (select) {

        select.addEventListener("change", function () {

            const idVenda = this.dataset.id;
            const novoStatus = this.value;

            // Pega a linha do pedido
            const linha = this.closest(".linha_pedido");


            if (!linha) {

                console.error("Linha do pedido não encontrada.");

                return;

            }


            // Remove todas as classes antigas
            linha.classList.remove(
                "status-criado",
                "status-aceito",
                "status-preparando",
                "status-pronto",
                "status-saiu_para_entrega",
                "status-entregue"
            );


            // Adiciona a classe do novo status
            linha.classList.add("status-" + novoStatus);


            console.log("ID da venda:", idVenda);
            console.log("Novo status:", novoStatus);


            // Envia para o PHP
            fetch("alterar_status.php", {

                method: "POST",

                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },

                body:
                    "id_venda=" + encodeURIComponent(idVenda) +
                    "&status=" + encodeURIComponent(novoStatus)

            })

            .then(function (response) {

                console.log("Status HTTP:", response.status);

                return response.text();

            })

            .then(function (resultado) {

                console.log("Resposta do PHP:", resultado);


                if (resultado.trim() !== "ok") {

                    console.error(
                        "O PHP retornou:",
                        resultado
                    );

                }

            })

            .catch(function (erro) {

                console.error(
                    "Erro ao alterar status:",
                    erro
                );

            });

        });

    });

});

/* ==============================
    PESQUISA DE CLIENTE
============================== */ 
const telefone = document.getElementById("telefone");
const listaClientes = document.getElementById("lista_clientes");

if (telefone && listaClientes) {

    telefone.addEventListener("input", function () {

        const numero = this.value.trim();

        if (numero.length < 3) {
            listaClientes.innerHTML = "";
            return;
        }

        fetch("buscar_clientes.php?telefone=" + encodeURIComponent(numero))
            .then(response => response.json())
            .then(clientes => {

                listaClientes.innerHTML = "";

                if (clientes.length === 0) {

                    listaClientes.innerHTML =
                        '<div class="cliente_nao_encontrado">Nenhum cliente encontrado</div>';

                    return;
                }

                clientes.forEach(cliente => {

                    const div = document.createElement("div");

                    div.classList.add("opcao_cliente");

                    div.innerHTML = `
                        <strong>${cliente.nome}</strong>
                        <span>${cliente.telefone}</span>
                    `;

                    div.addEventListener("click", function () {

                        telefone.value = cliente.telefone;

                        const campoNome = document.getElementById("nome");

                        if (campoNome) {
                            campoNome.value = cliente.nome;
                        }

                        listaClientes.innerHTML = "";
                    });

                    listaClientes.appendChild(div);
                });

            })
            .catch(error => {
                console.error("Erro ao buscar clientes:", error);
            });
    });
}
