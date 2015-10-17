/**
 * Created by ricardo on 06/11/15.
 */

var bakeries;
$(document).ready(function () {
    load_bakeries();

    //Get ready for a super piggy checking
    var in_events = window.location.href.split("?")[1] == "events";
    if (in_events) {
        load_events();
    } else {
        load_problems();
    }

    $("#failed").find("a").click(function (event) {
        event.preventDefault();
        if (in_events) {
            load_events(true, $("#filter").find("select").find("option:selected").val());
        } else {
            load_problems(true, $("#filter").find("select").find("option:selected").val());
        }

    });

    $("#refresh").click(function (event) {
        event.preventDefault();
        if (in_events) {
            load_events(true, $("#filter").find("select").find("option:selected").val());
        } else {
            load_problems(true, $("#filter").find("select").find("option:selected").val());
        }

    });

    $("#filter").find("select").change(function (event) {
        event.preventDefault();
        if (in_events) {
            load_events(true, $(this).val());
        } else {
            load_problems(true, $(this).val());
        }
    });
});
function load_problems(refreshing, filtering) {
    $("#loading-problems").removeClass("hidden");
    $("#no-entries").addClass("hidden");

    refreshing = refreshing !== undefined || refreshing;
    if (refreshing) {
        $("#table-problem").find("tbody").find("tr").each(function () {
            this.parentNode.removeChild(this);
        });
    }

    var args;
    if (filtering !== undefined && filtering != 0) {
        args = {problem: true, bakery: filtering};
    } else {
        args = {problem: true}
    }

    $.ajax({
        type: 'GET',
        url: 'api/v1/reports/logbook.php',
        data: args,
        dataType: 'json',
        encode: true
    }).done(function (data) {
        if (data.problems.length) {
            var problems = data.problems.length;
            for (var i = 0; i < problems; ++i) {
                var entry = data.problems[i];
                $("#table-problem")
                    .append($("<tr>")
                        .append($("<td>")
                            .text(entry.id)
                        ).append($("<td>")
                            .append($("<a>")
                                .attr("href", "?bakery=" + entry.bakery)
                                .text(get_bakery_name(entry.bakery))
                            )
                        ).append($("<td>")
                            .text(entry.description)
                        ).append($("<td>")
                            .text(entry.dough)
                        ).append($("<td>")
                            .text(entry.date)
                        ).append($("<td>")
                            .text(entry.hour)
                        )
                    );
            }

            $("#loading-problems").addClass("hidden");

        } else {
            $("#loading-problems").addClass("hidden");
            $("#no-entries").removeClass("hidden");
        }
    }).fail(function () {
        $("#failed").removeClass("hidden");
    });
}
function load_events(refreshing, filtering) {
    $("#loading-events").removeClass("hidden");
    $("#no-entries").addClass("hidden");

    refreshing = refreshing !== undefined || refreshing;
    if (refreshing) {
        $("#table-event").find("tbody").find("tr").each(function () {
            this.parentNode.removeChild(this);
        });
    }

    var args;
    if (filtering !== undefined && filtering != 0) {
        args = {event: true, bakery: filtering};
    } else {
        args = {event: true}
    }

    $.ajax({
        type: 'GET',
        url: 'api/v1/reports/logbook.php',
        data: args,
        dataType: 'json',
        encode: true
    }).done(function (data) {
        if (data.events.length) {
            var events = data.events.length;
            for (var i = 0; i < events; ++i) {
                var entry = data.events[i];
                $("#table-event")
                    .append($("<tr>")
                        .append($("<td>")
                            .text(entry.id)
                        ).append($("<td>")
                            .append($("<a>")
                                .attr("href", "?bakery=" + entry.bakery)
                                .text(get_bakery_name(entry.bakery))
                            )
                        ).append($("<td>")
                            .text(entry.description)
                        ).append($("<td>")
                            .text(entry.date)
                        ).append($("<td>")
                            .text(entry.hour)
                        )
                    );
            }

            $("#loading-events").addClass("hidden");

        } else {
            $("#loading-events").addClass("hidden");
            $("#no-entries").removeClass("hidden");
        }
    }).fail(function () {
        $("#failed").removeClass("hidden");
    });
}
function get_bakery_name(code) {
    var size = bakeries.length;
    for (var i = 0; i < size; ++i) {
        if (bakeries[i].id == code) {
            return bakeries[i].name;
        }
    }
}
function load_bakeries() {
    $.ajax({
        type: 'GET',
        url: 'api/v1/bakeries/bakery.php',
        data: {all: true},
        dataType: 'json',
        encode: true
    }).done(function (data) {
        if (!data.code) {
            bakeries = data.bakeries;
            var size = bakeries.length;

            for (var i = 0; i < size; ++i) {
                $("#filter").find("select").append($("<option>").attr("value", bakeries[i].id).text(bakeries[i].name));
            }
            $("#filter").find("option:selected").text("Todas");
        }
    });
}