// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// AJAX
$.ajax({
  url: "http://trackyourmoney.com/graficos",
  method: "get",
  data: "tipo=cuentas",
  dataType: "json",
  success: function(respuesta) {
    graficos_cuentas_saldos(respuesta);
  },
  error: function() {
      console.log("No se ha podido obtener la información");
  }
});

// Bar Chart Example
var ctx = document.getElementById("myBarChart");

function graficos_cuentas_saldos(arreglo) {
    let labelsmyLineChart = [];
    let datasmyLineChart = [];
    for (let index = 0; index < arreglo.length; index++) {
      const element = arreglo[index];
      labelsmyLineChart.push(element.nombre_corto);
      datasmyLineChart.push(element.saldo_inicial);
    }
    var myLineChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labelsmyLineChart,
        datasets: [{
          label: "Saldo",
          backgroundColor: "rgba(2,117,216,1)",
          borderColor: "rgba(2,117,216,1)",
          data: datasmyLineChart,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 6
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              maxTicksLimit: 5
            },
            gridLines: {
              display: true
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });
}


