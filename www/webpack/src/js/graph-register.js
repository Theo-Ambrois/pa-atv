var canvas = document.getElementById("graph-register-over-last-year"), ctx = canvas.getContext('2d');
fitToContainer(canvas);
var data = {
    labels: ["Ja", "Fe", "Ma", "Av", "Ma", "Ju", "Ju", "Ao", "Se", "Oc", "No", "Dé"],
    datasets: [{
        label: 'Nb d\'inscription',
        data: [120, 47, 98, 68, 89, 141, 32, 77, 45, 95, 37, 56],
        backgroundColor: [
            'rgba(255, 99, 132, 0.5)'
        ],
        borderColor: [
            'rgba(255,99,132,1)'
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
    type: 'line',
    data: data,
    options: options
});

function fitToContainer(canvas){
    canvas.style.width='100%';
    canvas.style.height='100%';
}