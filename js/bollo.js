/**
 * Created by ricardo on 21/10/15.
 */
var animate = ["bounce", "flash", "pulse", "rubberBand", "shake", "swing", "tada", "wobble"];
$(document).ready(function () {
    /* Vertical alignment of modal dialogs */
    $("body").on("shown.bs.modal", ".modal", function () {
        var idd = $(this).attr("id");
        if (idd != "loginModal") {
            $(this).css({
                'top': '50%',
                'margin-top': function () {
                    return -($(this).height() / 2);
                }
            });
        }
    });

    /* Bollo logo animation */
    var todaysAnimation = animate[Math.floor(Math.random() * animate.length)];
    $(".navbar-brand").mouseover(function () {
        $(this).addClass("animated " + todaysAnimation);
    }).mouseout(function () {
        $(this).removeClass("animated " + todaysAnimation);
    });

    var danger = "<i class='fa fa-exclamation-triangle'>";
    var forgot = "<a href='?forgot' class='alert-link' id='forgot-pw'>Olvidó la contraseña?</a>";
    //Login
    $("#login-form").submit(function (event) {
        event.preventDefault();
        $("#login-submit").addClass("disabled");
        $("#login-loading").removeClass("hidden");
        $("#login-error-msg").addClass("hidden");
        $.ajax({
            type: 'GET',
            url: 'api/v1/users/login.php',
            data: $('#login-form').serialize(),
            dataType: 'json',
            encode: true
        }).done(function (data) {
            if (!data.code) {
                /* Do all the update gui process */
                $("#login-close").click();
                window.location = "/bollo_web/?welcome";//TODO: Take him/her to another place
            } else if (data.code == 2) {
                $("#login-loading").addClass("hidden");
                $("#login-submit").removeClass("disabled");
                $("#login-error-msg").removeClass("hidden").html(danger + " Datos incorrectos. ")
                    .append(forgot);
            } else {
                $("#login-loading").addClass("hidden");
                $("#login-submit").removeClass("disabled");
                $("#login-error-msg").removeClass("hidden").html(danger + " La cuenta no ha sido activada");
            }
        }).fail(function () {
            $("#login-error-msg").removeClass("hidden").html(danger + " Error de conexión");
            $("#login-loading").addClass("hidden");
        });
    });

    $("#signup-form").submit(function (event) {
        event.preventDefault();
        var err = $("#signup-error-msg");
        $("#signup-submit").addClass("disabled");
        $("#signup-loading").removeClass("hidden");
        err.addClass("hidden");

        $.ajax({
            type: 'GET',
            url: 'api/v1/users/signup.php',
            data: $('#signup-form').serialize(),
            dataType: 'json',
            encode: true
        }).done(function (data) {
            var code = data.code;
            if (!code) {
                err.addClass("hidden");
                $("#signup-loading").addClass("hidden");
                window.location = "/bollo_web/?success=signup&email=" + $("#email").val();
            } else {
                switch (code) {
                    case 3:
                        err.removeClass("hidden").
                        html(danger + " Eres un puto bot.");
                        break;
                    case 4:
                        err.removeClass("hidden").
                        html(danger + " Algunos campos contienen información invalida.");
                        break;
                    case 16:
                        err.removeClass("hidden").
                        html(danger + " Por favor complete el captcha.");
                        break;
                    default:
                        $("#signup-error-msg").removeClass("hidden").
                        html(danger + " No se ha completado el registro. Intente luego.");
                }
                $("#signup-loading").addClass("hidden");
                $("#signup-submit").removeClass("disabled");
            }
        });
    });

    var email_failed = false, pw_error = false, confirmpw_error = false, user_failed = true;
    $("#email").focusout(function () {
        var data = {
            email: $("#email").val()
        };
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if (data.email.length > 5 && re.test(data.email)) {
            $.ajax({
                type: 'GET',
                url: 'api/v1/users/user.php',
                data: data,
                dataType: 'json',
                encode: true
            }).done(function (response) {
                email_failed = !response.code;
                if (!response.code) {
                    $("#email-group").addClass("has-error").removeClass("has-success");
                    $("#warning-block-email").removeClass("hidden");
                } else {
                    $("#email-group").removeClass("has-error").addClass("has-success");
                    $("#warning-block-email").addClass("hidden");
                }
            });
        } else {
            $("#email-group").addClass("has-error").
            removeClass("has-success").attr("title", "Correo electrónico inválido");
            $("#warning-block-email").addClass("hidden");
            email_failed = true;
        }
    });
    $("#username").focusout(function () {
        var data = {
            username: $("#username").val()
        };
        if (data.username.length > 5) {
            $.ajax({
                type: 'GET',
                url: 'api/v1/users/user.php',
                data: data,
                dataType: 'json',
                encode: true
            }).done(function (response) {
                user_failed = !response.code;
                if (!response.code) {
                    $("#username-group").addClass("has-error").removeClass("has-success");
                    $("#warning-block-username").removeClass("hidden");
                } else {
                    $("#username-group").removeClass("has-error").addClass("has-success");
                    $("#warning-block-username").addClass("hidden");
                }
            });
        } else {
            $("#username-group").addClass("has-error").
            removeClass("has-success").attr("title", "Nombre de usuario demasiado corto");
        }
    });

    $("#password").focusout(function () {
        var pw = $("#password").val();
        pw_error = pw.length < 6;
        if (pw.length < 6) {
            $("#password-group").removeClass("has-success").addClass("has-error");
            $("#warning-block-password").removeClass("hidden");
        } else {
            $("#password-group").removeClass("has-error").addClass("has-success");
            $("#warning-block-password").addClass("hidden");
        }
    });
    $("#c-password").focusout(function () {
        var pw = $("#password").val();
        var confirm = $(this).val();
        if (!!pw && !!confirm) {
            confirmpw_error = pw != confirm;
            if (pw == confirm) {
                $("#confirm-pw-group").removeClass("has-error").addClass("has-success");
                $("#warning-block-pw-mismatch").addClass("hidden");
            } else {
                $("#confirm-pw-group").removeClass("has-success").addClass("has-error");
                $("#warning-block-pw-mismatch").removeClass("hidden");
            }
        } else {
            pw_error = confirmpw_error = true;
            $("#confirm-pw-group").removeClass("has-success").addClass("has-error");
            $("#warning-block-pw-mismatch").addClass("hidden");
        }
    });
    $("#signup-submit").click(function (event) {
        if (email_failed || pw_error || confirmpw_error || user_failed) {
            event.preventDefault();
            if (email_failed) {
                $("#email").focus();
                $("#signup-error-msg").removeClass("hidden").
                html(danger + " Especifique un nombre de correo electrónico válido");
            } else if (user_failed) {
                $("#username").focus();
                $("#signup-error-msg").removeClass("hidden").html(danger + " Especifique un nombre de usuario válido");
            } else if (confirmpw_error) {
                $("#password").focus();
                $("#signup-error-msg").removeClass("hidden").
                html(danger + " La contraseña debe tener al menos 7 caracteres.");
            } else {
                $("#c-password").focus();
                $("#signup-error-msg").removeClass("hidden").
                html(danger + " Ambas contraseñas deben coincidir");
            }
        } else {
            $("#signup-error-msg").addClass("hidden");
        }
    });

    $("#forgot-form").submit(function (event) {
        event.preventDefault();
        $("#pw-recovery-error-msg").addClass("hidden");
        $.ajax({
            type: 'GET',
            url: 'api/v1/users/forgot.php',
            data: $('#forgot-form').serialize(),
            dataType: 'json',
            encode: true
        }).done(function (data) {
            var code = data.code;
            if (!code) {
                window.location = "/bollo_web/?success=updated-pw"
            } else if (code == 5) {
                $("#pw-recovery-error-msg").removeClass("hidden").html(danger + " Datos incorrectos!");
            }
        });
    });
    $("#pw-recovery-submit").click(function (event) {
        if (pw_error || confirmpw_error) {
            event.preventDefault();
            if (pw_error) {
                $("#password").focus();
                $("#pw-recovery-error-msg").removeClass("hidden").html(danger + " La contraseña es demasiado corta");
            } else {
                $("#c-password").focus();
                $("#pw-recovery-error-msg").removeClass("hidden").html(danger + " Las contraseñas no coinciden");
            }
        } else {
            $("#pw-recovery-error-msg").addClass("hidden");
        }
    });

    $("#recovery-request-form").submit(function (event) {
        event.preventDefault();
        var email = $('#recovery-request-form').serialize();
        $.ajax({
            type: 'GET',
            url: 'api/v1/users/user.php',
            data: email,
            dataType: 'json',
            encode: true
        }).done(function (data) {
            if (!data.code) {
                $.ajax({
                    type: 'GET',
                    url: 'api/v1/users/forgot.php',
                    data: email,
                    dataType: 'json',
                    encode: true
                }).done(function (data) {
                    var code = data.code;
                    if (!code) {
                        $("#recovery-request-form").removeClass("has-error");
                        $("#forgot-block-password").addClass("hidden");
                        window.location = "/bollo_web/?success=sent-recovery-email" +
                            "&email=" + $("#forgot-email").val();
                    } else {
                        $("#recovery-request-form").addClass("has-error");
                        $("#forgot-block-password").removeClass("hidden")
                            .html(danger + " Ocurrió un error grave. Intente luego!");

                    }
                });
            } else {
                $("#recovery-request-form").addClass("has-error");
                $("#forgot-block-password").removeClass("hidden")
                    .html(danger + "Ese correo no está asociado a ningún usuario :(.");
            }
        });
    });

    $("#create-bakery-form").submit(function (event) {
        event.preventDefault();
        $("#create-loading").removeClass("hidden");
        $("#create-error-msg").addClass("hidden");
        $.ajax({
            type: 'GET',
            url: 'api/v1/bakeries/create.php',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true
        }).done(function (data) {
            if (!data.code) {
                window.location = '/bollo_web/?bakery=' + String(data.bakery.id);
            } else {
                $("#create-loading").addClass("hidden");
                $("#create-error-msg").removeClass("hidden");
            }
        });
    });

    $("#edit-bakery-form").submit(function (event) {
        event.preventDefault();
        $("#edit-loading").removeClass("hidden");
        $("#edit-error-msg").addClass("hidden");
        $("#edit-success-msg").addClass("hidden");
        $.ajax({
            type: 'GET',
            url: 'api/v1/bakeries/modify.php',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true
        }).done(function (data) {
            if (!data.code) {
                $("#edit-success-msg").removeClass("hidden");
                $("#edit-loading").addClass("hidden");
            } else {
                $("#edit-loading").addClass("hidden");
                $("#edit-error-msg").removeClass("hidden");
            }
        });
    });
});