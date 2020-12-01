// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#292b2c";

// AJAX
$("#dos_fechas").click(function(e) {
    var fecha1 = jQuery("#id_2_fechas_btn1").val();
    var fecha2 = jQuery("#id_2_fechas_btn2").val();
    var formData = {
        tipo: "entre_2_fechas",
        fecha_incio: fecha1,
        fecha_fin: fecha2
    };

    $.ajax({
        url: "http://trackyourmoney.com/graficos",
        method: "get",
        data: formData,
        dataType: "json",
        success: function(respuesta) {
            grafico_entre_2_fechas(respuesta);
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
});
// let frutas = "Uvas: "+300+"\n"+"Manzanas:"+1000;

function grafico_entre_2_fechas(arreglo) {
    if (Array.isArray(arreglo)) {
        alert("No hay datos para mostrar");
    } else {
        
        $("#nadaFecha").hide();

        var Pie = document.getElementById("PieChart");
        var myPieChart = new Chart(Pie, {
            type: "pie",
            data: {
                labels: ["Gastos", "Ingresos"],
                datasets: [
                    {
                        data: [arreglo.gastos, arreglo.ingresos],
                        backgroundColor: ["#dc3545", "#28a745"]
                    }
                ]
            }
        });
        arreglo = [];
    }
}

var formDataMes = {
    tipo: "mes"
};

$.ajax({
    url: "http://trackyourmoney.com/graficos",
    method: "get",
    data: formDataMes,
    dataType: "json",
    success: function(respuesta) {
        ultimoMes(respuesta);
    },
    error: function() {
        console.log("No se ha podido obtener la información");
    }
});
function ultimoMes(arreglo) {
    if (!Array.isArray(arreglo)) {
        $("#nada").hide();
        var Pie = document.getElementById("PieChartUltimoMes");
        var myPieChart = new Chart(Pie, {
            type: "pie",
            data: {
                labels: ["Gastos", "Ingresos"],
                datasets: [
                    {
                        data: [arreglo.gastos, arreglo.ingresos],
                        backgroundColor: ["#007bff", "#ffc107"]
                    }
                ]
            }
        });

    }
}

var formDataMes = {
  tipo: "anio"
};

$.ajax({
  url: "http://trackyourmoney.com/graficos",
  method: "get",
  data: formDataMes,
  dataType: "json",
  success: function(respuesta) {
      ultimoAnio(respuesta);
  },
  error: function() {
      console.log("No se ha podido obtener la información");
  }
});
function ultimoAnio(arreglo) {
    if (!Array.isArray(arreglo)) {
        $("#nadaAnio").hide();
        var Pie = document.getElementById("PieChartUltimoAnio");
        var myPieChart = new Chart(Pie, {
            type: "pie",
            data: {
                labels: ["Gastos", "Ingresos"],
                datasets: [
                    {
                        data: [arreglo.gastos, arreglo.ingresos],
                        backgroundColor: ["#ff8700", "#d51fbf"]
                    }
                ]
            }
        });
    }
}

// AJAX
$("#mesCalendarioBtn").click(function(e) {
  var mes = jQuery("#mesCalendarioInput").val();

  var formData = {
      tipo: "mesCalendario",
      mes: mes
  };

  $.ajax({
      url: "http://trackyourmoney.com/graficos",
      method: "get",
      data: formData,
      dataType: "json",
      success: function(respuesta) {
          grafico_mesCalendario(respuesta);
      },
      error: function() {
          console.log("No se ha podido obtener la información");
      }
  });
});
function grafico_mesCalendario(arreglo) {
    if (Array.isArray(arreglo)) {
      alert("No hay datos para mostrar");
    }else {
    $("#nadaMesCalendario").hide();
      var Pie = document.getElementById("PieChartUltimoMesCalendario");
      var myPieChart = new Chart(Pie, {
          type: "pie",
          data: {
              labels: ["Gastos", "Ingresos"],
              datasets: [
                  {
                      data: [arreglo.gastos, arreglo.ingresos],
                      backgroundColor: ["#dc3545", "#28a745"]
                  }
              ]
          }
      });
  }
}






$("#anioCalendarioBtn").click(function(e) {
  var anio = jQuery("#anioCalendarioInput").val();

  var formData = {
      tipo: "anioCalendario",
      anio: anio
  };

  $.ajax({
      url: "http://trackyourmoney.com/graficos",
      method: "get",
      data: formData,
      dataType: "json",
      success: function(respuesta) {
          grafico_anioCalendario(respuesta);
      },
      error: function() {
          console.log("No se ha podido obtener la información");
      }
  });
});
function grafico_anioCalendario(arreglo) {
    if (Array.isArray(arreglo)) {
        alert("No hay datos para mostrar");
      } else {
    $("#nadaAnioCalendario").hide();
      var Pie = document.getElementById("PieChartUltimoAnioCalendario");
      var myPieChart = new Chart(Pie, {
          type: "pie",
          data: {
              labels: ["Gastos", "Ingresos"],
              datasets: [
                  {
                      data: [arreglo.gastos, arreglo.ingresos],
                      backgroundColor: ["#ff0000", "#542cb2"]
                  }
              ]
          }
      });
  }
}




















































