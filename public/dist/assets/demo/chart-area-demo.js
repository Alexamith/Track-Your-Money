// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';


// AJAX
$.ajax({
  url: "http://trackyourmoney.com/graficos",
  method: "get",
  data: "tipo=ingresos",
  dataType: "json",
  success: function(respuesta) {
    ingresos(respuesta);
  },
  error: function() {
      console.log("No se ha podido obtener la información");
  }
});



// Area Chart Example
var ctxIngresos = document.getElementById("myAreaChart");

function ingresos(arreglo) {
    let labelsIngresos = [];
    let dataIngresos = [];
    for (let index = 0; index < arreglo.length; index++) {
      const element = arreglo[index];
      labelsIngresos.push(element.categoria_padre);
      dataIngresos.push(element.presupuesto);
    }
    var myLineChart = new Chart(ctxIngresos, {
      type: 'line',
      data: {
        labels:labelsIngresos,
        datasets: [{
          label: "Ingresos",
          lineTension: 0.3,
          backgroundColor: "rgba(2,117,216,0.2)",
          borderColor: "rgba(2,117,216,1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(2,117,216,1)",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(2,117,216,1)",
          pointHitRadius: 50,
          pointBorderWidth: 2,
          data: dataIngresos,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              maxTicksLimit: 5
            },
            gridLines: {
              color: "rgba(0, 0, 0, .125)",
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });
}


// AJAX
$.ajax({
  url: "http://trackyourmoney.com/graficos",
  method: "get",
  data: "tipo=gastos",
  dataType: "json",
  success: function(respuesta) {
    gastos(respuesta);
  },
  error: function() {
      console.log("No se ha podido obtener la información");
  }
});

var ctxGastos = document.getElementById("myAreaGastos");
function gastos(arreglo) {
  let labelsGastos = [];
  let dataGastos = [];
  for (let index = 0; index < arreglo.length; index++) {
    const element = arreglo[index];
    labelsGastos.push(element.categoria_padre);
    dataGastos.push(element.presupuesto);
  }
  var myLineChart = new Chart(ctxGastos, { 
    type: 'line',
    data: {
      labels: labelsGastos,
      datasets: [{
        label: "Gastos",
        lineTension: 0.3,
        backgroundColor: "rgba(255,137,137,0.5)",
        borderColor: "#de0404",
        pointRadius: 5,
        pointBackgroundColor: "#de0404",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "#fc6868",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: dataGastos,
      }],
    },
    options: {
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          ticks: {
            min: 0,
            maxTicksLimit: 5
          },
          gridLines: {
            color: "rgba(0, 0, 0, .15)",
          }
        }],
      },
      legend: {
        display: false
      }
    }
  });
  
}
