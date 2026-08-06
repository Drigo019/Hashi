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
/*
let produtosDisponiveis = JSON.parse(localStorage.getItem('produtos_restaurante')) || [
    { nome: 'X-Burguer Especial', preco: 25.00 },
    { nome: 'Batata Frita', preco: 12.00 }
];

// 2. Carrega o carrinho salvo ou começa com um carrinho vazio
let carrinho = JSON.parse(localStorage.getItem('carrinho_restaurante')) || [];
let total = 0;

// Executa assim que a página carrega para desenhar tudo na tela
window.onload = function() {
    desenharCardapio();
    atualizarCarrinho();
};

// FUNÇÃO DO CAIXA: Cadastra o produto e salva no LocalStorage
function cadastrarProduto() {
    const nomeInput = document.getElementById('novo-nome');
    const precoInput = document.getElementById('novo-preco');

    const nome = nomeInput.value.trim();
    const preco = parseFloat(precoInput.value);

    if (nome === '' || isNaN(preco) || preco <= 0) {
        alert('Por favor, insira um nome válido e um preço maior que zero.');
        return;
    }

    produtosDisponiveis.push({ nome, preco });

    // Salva a lista de produtos atualizada no navegador
    localStorage.setItem('produtos_restaurante', JSON.stringify(produtosDisponiveis));

    nomeInput.value = '';
    precoInput.value = '';

    desenharCardapio();
}

// Desenha os produtos na tela dinamicamente
function desenharCardapio() {
    const container = document.getElementById('container-cardapio');
    container.innerHTML = '';

    produtosDisponiveis.forEach(produto => {
        let div = document.createElement('div');
        div.className = 'item-cardapio';
        
        div.innerHTML = `
            <h3>${produto.nome}</h3>
            <p>R$ ${produto.preco.toFixed(2)}</p>
            <button onclick="adicionarAoCarrinho('${produto.nome}', ${produto.preco})">Pedir</button>
        `;
        
        container.appendChild(div);
    });
}

// Adiciona ao carrinho e salva o estado atual do carrinho
function adicionarAoCarrinho(nome, preco) {
    carrinho.push({ nome, preco });
    localStorage.setItem('carrinho_restaurante', JSON.stringify(carrinho));
    atualizarCarrinho();
}

// Atualiza o carrinho visualmente e recalcula o total
function atualizarCarrinho() {
    const lista = document.getElementById('lista-carrinho');
    const spanTotal = document.getElementById('valor-total');
    
    lista.innerHTML = '';
    total = 0;

    carrinho.forEach((item, index) => {
        total += item.preco;
        let li = document.createElement('li');
        li.innerText = `${item.nome} - R$ ${item.preco.toFixed(2)} `;
        
        let btnRemover = document.createElement('button');
        btnRemover.innerText = 'X';
        btnRemover.onclick = () => removerItem(index);
        
        li.appendChild(btnRemover);
        lista.appendChild(li);
    });

    spanTotal.innerText = total.toFixed(2);
}

// Remove o item e atualiza o LocalStorage do carrinho
function removerItem(index) {
    carrinho.splice(index, 1);
    localStorage.setItem('carrinho_restaurante', JSON.stringify(carrinho));
    atualizarCarrinho();
}

// FUNÇÃO EXTRA: Se quiser resetar o cardápio para o padrão de fábrica
function resetarCardapio() {
    localStorage.removeItem('produtos_restaurante');
    location.reload(); // Recarrega a página
}
*/
