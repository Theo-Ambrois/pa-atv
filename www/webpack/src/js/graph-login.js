var canvas = document.getElementById("graph-login-over-last-week"), ctx = canvas.getContext('2d');
fitToContainer(canvas);
var data = {
    labels: ["1", "2", "3", "4", "5", "6", "7"],
    datasets: [{
        label: 'Nb de connexions',
        data: [2, 4, 12, 6, 7, 5, 17],
        backgroundColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)'
        ],
        borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
    }]
};

var options = {

    scales: {
        yAxes: [{
            ticks: { // utile pour que les valeurs min et max ne soient pas celles du dataset
                beginAtZero:true,
                suggestedMax: 15
            }
        }]
    },
    legend: {
        display: false,
    }
};
var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
});

function fitToContainer(canvas){
    canvas.style.width='100%';
    canvas.style.height='100%';
}