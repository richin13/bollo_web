/**
 * Created by ricardo on 06/11/15.
 */

$(document).ready(function () {
    load_bakeries(window.location.href.split("=")[1]);

    $("#refresh-bakery").click(function (event) {
        event.preventDefault();
        $("#content-bakeries").empty();
        load_bakeries(window.location.href.split("=")[1]);
    })
});

function load_bakeries(filtering) {
    $("#loading-bakeries").removeClass("hidden");
    $("#failed").addClass("hidden");
    $("#no-bakeries").addClass("hidden");

    var args;
    if (filtering === undefined) {
        args = {all: true};
    } else {
        args = {id: filtering};
    }

    $.ajax({
        type: 'GET',
        url: 'api/v1/bakeries/bakery.php',
        data: args,
        dataType: 'json',
        encode: true
    }).done(function (data) {
        if (!data.code) {
            var bakeries = data.bakeries;
            var size = bakeries.length;

            if (size) {
                for (var i = 0; i < size; ++i) {
                    $("#content-bakeries")
                        .append($("<div>")
                            .attr("class", "row")
                            .attr("id", "bakery-" + bakeries[i].id)
                            .append($("<hr>"))
                            .append($("<h4>")
                                .attr("class", "bakery-name-h")
                                .append($("<strong>")
                                    .text(bakeries[i].name + " "))
                                .append($("<small>")
                                    .append($("<a>")
                                        .attr("href", "?charts=" + bakeries[i].id)
                                        .attr("title", "Gráficos")
                                        .append($("<i>")
                                            .attr("class", "fa fa-bar-chart")
                                        )
                                    )
                                ).append($("<small>")
                                    .append($("<a>")
                                        .attr("href", "?modify=" + bakeries[i].id)
                                        .attr("title", "Editar")
                                        .append($("<i>")
                                            .attr("class", "fa fa-pencil-square-o"))
                                    )
                                ).append($("<small>")
                                    .append($("<a>")
                                        .attr("href", "?delete=" + bakeries[i].id)
                                        .attr("title", "Eliminar")
                                        .attr("class", "delete-bakery-link")
                                        .append($("<i>")
                                            .attr("class", "delete-bakery fa fa-trash")
                                        )
                                    )
                                )
                            )
                            .append($("<address>")
                                .append($("<strong>")
                                    .text("Provincia: ")
                                ).append(get_province_name(bakeries[i].province) + "<br>")
                                .append($("<strong>")
                                    .text("Ciudad: ")
                                ).append(bakeries[i].city + "<br>")
                                .append($("<strong>")
                                    .text("Existencias: ")
                                ).append(bakeries[i].stock + "<br>")
                                .append($("<strong>")
                                    .text("Estado: ")
                                ).append(bakeries[i].status)
                            )
                        );
                }
                $("#loading-bakeries").addClass("hidden");
            } else {
                $("#no-bakeries").removeClass("hidden");
            }
        } else {
            $("#loading-bakeries").addClass("hidden");
            $("#failed").removeClass("hidden");
        }
    });
}

$(document).on('click', '.delete-bakery-link', function (event) {
    event.preventDefault();
    var bakery_id = $(this).attr("href").split("=")[1];
    swal({
        title: "La operación es irreversible",
        text: "¿Está seguro/a que desea eliminar la panadería?",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        confirmButtonColor: "#e74c3c"
    }, function (accepted) {
        if (accepted) {
            $.ajax({
                type: 'GET',
                url: 'api/v1/bakeries/delete.php',
                data: {id: bakery_id},
                dataType: 'json',
                encode: true
            }).done(function (data) {
                if (!data.code) {
                        $("#bakery-" + bakery_id).fadeOut(500, function () {
                            $(this).remove();
                        });
                    swal("Borrada!", "Se ha eliminado la panadería!", "success");
                } else {
                    swal("Atención!", "La panadería NO se ha eliminado!", "warning");
                }
            }).fail(function () {
                swal("Error!", "Ocurrió un error", "error");
            });
        } else {
            event.preventDefault();
            }
    });
});

function get_province_name(code) {
    switch (code) {
        case 1:
            return "San José";
        case 2:
            return "Alajuela";
        case 3:
            return "Cartago";
        case 4:
            return "Heredia";
        case 5:
            return "Guanacaste";
        case 6:
            return "Puntarenas";
        case 7:
            return "Limón";
        default:
            return "Overseas";
    }
}