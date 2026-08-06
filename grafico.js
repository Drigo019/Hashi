const ctx = document.getElementById('graficoPizza').getContext('2d');
const graficoPizza = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Vermelho', 'Azul', 'Amarelo'],
        datasets: [{
            label: 'Votos',
            data: [12, 19, 3],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ]
        }]
    },
    options: {
        responsive: true
    }
});
