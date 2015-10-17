/**
 * Created by ricardo on 14/11/15.
 */
/*
 var randomScalingFactor = function () {
 return Math.round(Math.random() * 100)
 };
 */
/*
 var barChartData = {
 labels: ["January", "February", "March", "April", "May", "June", "July"],
 datasets: [
 {
 //                fillColor : "rgba(220,220,220,0.5)",
 //                strokeColor : "rgba(220,220,220,0.8)",
 //                highlightFill: "rgba(220,220,220,0.75)",
 //                highlightStroke: "rgba(220,220,220,1)",
 data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
 },
 {
 //                fillColor : "rgba(151,187,205,0.5)",
 //                strokeColor : "rgba(151,187,205,0.8)",
 //                highlightFill : "rgba(151,187,205,0.75)",
 //                highlightStroke : "rgba(151,187,205,1)",
 data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
 }
 ]
 };
 */
function create_labels(json) {
    var size = json.length;
    var labels = [];
    for (var i = 0; i < size; ++i) {
        if (labels.indexOf(json[i].date) < 0) {
            labels.push(json[i].date);
        }
    }

    return labels;
}

function create_dataset(labels, production, bakeries) {
    var size = bakeries.length;
    var datasets = [];

    if (bakery_id) {
        datasets.push({
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: fetch_data(production, labels, bakery_id)
        });
    } else {
        for (var i = 0; i < size; ++i) {
            datasets.push({
                label: bakeries[i].name,
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data: fetch_data(production, labels, bakeries[i].id)
            });
        }
    }

    return datasets;
}

function fetch_data(production, labels, bakery) {
    var size = labels.length;
    var data = [];

    for (var i = 0; i < size; ++i) {
        data.push(get_production(production, labels[i], bakery));
    }

    return data;
}

function get_production(production, date, bakery) {
    var size = production.length;

    for (var i = 0; i < size; ++i) {
        if (production[i].bakery == bakery && production[i].date == date) {
            return production[i].quantity;
        }
    }

    return 0;
}

$(document).ready(function () {
    $("#loading-charts").removeClass("hidden");
    $.ajax({
        type: 'GET',
        url: 'api/v1/bakeries/production.php',
        data: {all: true},
        dataType: 'json',
        encode: true
    }).done(function (raw_data) {
        var _labels = create_labels(raw_data.data);

        $.ajax({
            type: 'GET',
            url: 'api/v1/bakeries/bakery.php',
            data: {all: true},
            dataType: 'json',
            encode: true
        }).done(function (bakeries) {
            var chart_data = create_dataset(_labels, raw_data.data, bakeries.bakeries);

            var chart_content = {
                labels: _labels,
                datasets: chart_data
            };
            $("#loading-charts").addClass("hidden");
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx).Bar(chart_content, {
                responsive: true,
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %> piezas"
            });
        });
    });
});
