function alternarDiv() {
    var menu = document.getElementById("menu");
    var imagem = document.getElementById("ico_menu");

    menu.classList.toggle("aberto");
    imagem.classList.toggle("girado");

    // Salva estado
    if (menu.classList.contains("aberto")) {
        localStorage.setItem("menuEstado", "aberto");
    } else {
        localStorage.setItem("menuEstado", "fechado");
    }
}
// Aplica o estado salvo ao carregar
window.onload = function() {
    var menu = document.getElementById("menu");
    var estado = localStorage.getItem("menuEstado");

    if (estado === "aberto") {
        menu.classList.add("aberto");
    }
}

function atualizarTotalBanco() {
    let total = 0;

    // Exemplo: somando produtos (ajuste conforme seu sistema)
    document.querySelectorAll(".valor-item").forEach(item => {
        total += parseFloat(item.textContent.replace("R$", "").replace(",", ".")) || 0;
    });

    // Atualiza na tela (se quiser)
    document.getElementById("total_pedido").innerText = "R$ " + total.toFixed(2);

    // 🔥 Aqui manda pro input hidden
    document.getElementById("valor_total").value = total.toFixed(2);
}

/*====================
        CARRINHO
====================*/
function mostrarMensagem(texto) {
    let msg = document.getElementById("msg");

    msg.textContent = texto;
    msg.classList.remove("d-none"); 

    setTimeout(() => {
        msg.classList.add("d-none"); 
    }, 2000);
}