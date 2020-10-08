<div class="col-10 margin-left-auto">
    <!-- Model small x4-->
    <div class="row --isSpaceBetween">
        <div class="col-2">
            <div class="card card--isSmall">
                <div class="row">
                    <img src="webpack/img/user-icon.png" class="col-1 icons">
                    <p class="paddingless marginless">Utilisateurs</p>
                </div>
                <p class="card-text card-text--with-bottom-line marginless"><?= $users ?></p>
            </div>
        </div>
        <div class="col-2">
            <div class="card card--isSmall">
                <div class="row">
                    <img src="webpack/img/document-icon.png" class="col-1 icons">
                    <p class="paddingless marginless">Documents</p>
                </div>
                <p class="card-text card-text--with-bottom-line marginless"><?= $documents ?></p>
            </div>
        </div>
        <div class="col-2">
            <div class="card card--isSmall">
                <div class="row">
                    <img src="webpack/img/event-icon.png" class="col-1 icons">
                    <p class="paddingless marginless">Evenements</p>
                </div>
                <p class="card-text card-text--with-bottom-line marginless"><?= $events ?></p>
            </div>
        </div>
        <div class="col-2">
            <div class="card card--isSmall">
                <div class="row">
                    <img src="webpack/img/group-icon.png" class="col-1 icons">
                    <p class="paddingless marginless">Roles</p>
                </div>
                <p class="card-text card-text--with-bottom-line marginless"><?= $roles ?></p>
            </div>
        </div>
    </div>
    <!-- Model medium x3-->
    <div class="row --isSpaceBetween">
        <div class="col-3">
            <div class="card card--isMedium">
                <div class="card-text card-text--small">
                    Inscriptions sur les 12 derniers mois
                </div>
                <div class="canvas">
                    <canvas id="graph-register-over-last-year"></canvas>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card--isMedium">
                <div class="card-text card-text--small">
                    Documents upload sur les 30 derniers jours
                </div>
                <div class="canvas">
                    <canvas id="graph-document-upload-over-last-month"></canvas>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card--isMedium">
                <div class="card-text card-text--small">
                    Evènements sur les 7 derniers jours
                </div>
                <div class="canvas">
                    <canvas id="graph-event-over-last-week"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event chart -->
<?php
    echo "<script>var canvas = document.getElementById(\"graph-event-over-last-week\"), ctx = canvas.getContext('2d');
fitToContainer(canvas);
var data = {
    labels: [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\"],
    datasets: [{
        label: 'Nb d\'évènement',
        data: [".implode(',', $eventsNb)."],
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
}</script>";
?>

<!-- Register chart -->
<?php
    echo "<script>var canvas = document.getElementById(\"graph-register-over-last-year\"), ctx = canvas.getContext('2d');
fitToContainer(canvas);
var data = {
    labels: [\"Ja\", \"Fe\", \"Ma\", \"Av\", \"Ma\", \"Ju\", \"Ju\", \"Ao\", \"Se\", \"Oc\", \"No\", \"Dé\"],
    datasets: [{
        label: 'Nb d\'inscription',
        data: [".implode(',', $registerNb)."],
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
}</script>";
?>

<!-- Documents chart -->
<?php
    echo "<script>var canvas = document.getElementById(\"graph-document-upload-over-last-month\"), ctx = canvas.getContext('2d');
fitToContainer(canvas);
var data = {
    labels: [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\",
             \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\",
             \"29\", \"30\"],
    datasets: [{
        label: 'Nb de documents upload',
        data: [".implode(',', $documentsNb)."],
        backgroundColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 99, 132, 0.5)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 99, 132, 0.5)'
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
}</script>";
?>
