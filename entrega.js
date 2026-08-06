const select = document.getElementById("tipo_entrega");
const endereco = document.getElementById("endereco");

function verificarEntrega() {
    if (select.value === "entregar") {
        endereco.style.display = "block";
    } else {
        endereco.style.display = "none";
    }
}

select.addEventListener("change", verificarEntrega);
window.onload = verificarEntrega;