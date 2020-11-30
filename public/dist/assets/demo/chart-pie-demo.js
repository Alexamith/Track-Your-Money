// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#292b2c";

// Pie Chart Example
// var Pie = document.getElementById("PieChart");
// var myPieChart = new Chart(Pie, {
//   type: 'pie',
//   data: {
//     labels: ["Blue", "Red", "Yellow", "Green"],
//     datasets: [{
//       data: [12.21, 15.58, 19.25, 8.32],
//       backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
//     }],
//   },
// });
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
    if (arreglo[0].gastos == null) {
        alert("No hay datos para mostrar");
    } else {
        var Pie = document.getElementById("PieChart");
        var myPieChart = new Chart(Pie, {
            type: "pie",
            data: {
                labels: ["Gastos", "Ingresos"],
                datasets: [
                    {
                        data: [arreglo[0].gastos, arreglo[1].gastos],
                        backgroundColor: ["#dc3545", "#28a745"]
                    }
                ]
            }
        });
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
    if (arreglo[0].gastos != null) {
        $("#nada").hide();
        var Pie = document.getElementById("PieChartUltimoMes");
        var myPieChart = new Chart(Pie, {
            type: "pie",
            data: {
                labels: ["Gastos", "Ingresos"],
                datasets: [
                    {
                        data: [arreglo[0].gastos, arreglo[1].gastos],
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
  if (arreglo[0].gastos != null) {
      $("#nadaAnio").hide();
      var Pie = document.getElementById("PieChartUltimoAnio");
      var myPieChart = new Chart(Pie, {
          type: "pie",
          data: {
              labels: ["Gastos", "Ingresos"],
              datasets: [
                  {
                      data: [arreglo[0].gastos, arreglo[1].gastos],
                      backgroundColor: ["#ff8700", "#d51fbf"]
                  }
              ]
          }
      });
  }
}
