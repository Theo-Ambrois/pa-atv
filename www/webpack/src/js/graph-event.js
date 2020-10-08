var canvas = document.getElementById("graph-event-over-last-week"), ctx = canvas.getContext('2d');
fitToContainer(canvas);
var data = {
    labels: ["1", "2", "3", "4", "5", "6", "7"],
    datasets: [{
        label: 'Nb d\'évènement',
        data: [1, 2, 3, 0, 1, 2, 3],
        backgroundColor: [
            'rgba(54, 162, 235, 0.5)'
        ],
        borderColor: [
            'rgba(54, 162, 235, 1)'
        ],
        borderWidth: 1
    }]
};

var options = {

    scales: {
        yAxes: [{
            ticks: { // utile pour que les valeurs min et max ne soient pas celles du dataset
                beginAtZero:true,
                suggestedMax: 5
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