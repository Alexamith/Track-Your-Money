/*!
 * Start Bootstrap - SB Admin v6.0.2 (https://startbootstrap.com/template/sb-admin)
 * Copyright 2013-2020 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
 */
(function($) {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
})(jQuery);

$("#modalEdit").modal();
$("#modal_editar_cuenta").modal();
$("#modal_editar_categoria_padre").modal();
$("#modal_editar_transaccion").modal();
$("#compartirCuenta").modal();
$("#divCreditoEdit").hide();

$(document).ready(function() {
    $("#tipoTransferencia").click(function() {
        $("#divCredito").show();
    });
    $("#tipoOtro").click(function() {
        $("#divCredito").hide();
    });
    $("#tipoTransferenciaE").click(function() {
        $("#divCreditoEdit").show();
    });
    $("#tipoOtroE").click(function() {
        $("#divCreditoEdit").hide();
    });
    //----- Open model CREATE -----//

    // CREATE
    $("#btn-buscar").click(function(e) {
        var correo = jQuery("#correo-buscar").val();
        var id = jQuery("#id-compartir").val();
        var usuario_id;
        var cuenta_id =jQuery("#id-compartir").val();

        $.ajax({
            url: "http://trackyourmoney.com/usuario",
            method: "get",
            data: "correo=" + correo,
            dataType: "json",
            success: function(respuesta) {
                var size = respuesta.length;
                if (size == 0) {
                    $("#cuenat-no-existe").text(
                        "El nombre de usuario no está registrado"
                    );
                    $("#cuenat-no-existe").show();
                } else {
                    $("#cuenat-no-existe").hide();
                    var nombre;
                    respuesta.forEach(element => {
                        nombre = element["name"];
                        usuario_id = element["id"];
                    });
                    var pregunta = confirm(
                        "¿Desea compartir esta cuenta con " + nombre + "?"
                    );
                    if (pregunta) {
                        var value = $("[name='_token']").val();
                        var formData = {
                            _token: value,
                            usuario_id: usuario_id,
                            cuenta_id: cuenta_id
                        };
                        $.ajax({
                            url: "http://trackyourmoney.com/compartir",
                            method: "post",
                            data: formData,
                            dataType: "json",
                            success: function(respuesta) {
                                $("#compartirCuenta").modal('toggle');
                                alert(respuesta);
                            },
                            error: function() {
                                alert(
                                    "No se ha podido obtener la información"
                                );
                            }
                        });
                    }
                }
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        });
    });
});
