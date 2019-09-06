<template>
  <main>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Graficos</h1>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <!-- DONUT CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Ventas por Sabor</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  
                </div>
              </div>
              <!-- <div class="card-body">
                <canvas id="donutChart" style="height:230px; min-height:230px"></canvas>
              </div> -->

              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class="chart-responsive">
                      <canvas id="donutChart" height="250"></canvas>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <ul  class="chart-legend clearfix">
                      <li v-for="(item,index) in arrayingreso_sabor" :key="index">
                        <i class="fas fa-ice-cream" :style="{color:item.color}" >
                        </i> {{item.sabor}}: <span class="badge text-white" :style="{'background-color':item.color}">{{item.total}}</span>
                      </li>                      
                    </ul>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- PIE CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="height:230px; min-height:230px"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Line Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="height:250px; min-height:250px"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="height:230px; min-height:230px"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    {{FechaInicial}} to {{FechaFinal}}
  </main>
</template>

<script>
export default {
  
  data() {
    return {
      arrayingreso_sabor: [],    
      chartData: '',
      FechaInicial: moment().subtract(6, 'days').format("YYYY-MM-DD HH:mm:ss"),
      FechaFinal: moment().format("YYYY-MM-DD HH:mm:ss"),
    };
  },

  methods: {
    ingreso_sabor(FechaInicial, FechaFinal) {
      let me = this;
      var url =
        "grafico/ingreso_sabor?FechaInicial=" +
        FechaInicial +
        "&FechaFinal=" +
        FechaFinal;
      axios
        .get(url)
        .then(function(response) {
            var responseData = response.data;
            me.arrayingreso_sabor = responseData;  
            console.log(me.arrayingreso_sabor);
            me.chartData = {
                labels: responseData.map(item => item.sabor),
                datasets: [
                    {
                        label: 'Sabor',
                        // backgroundColor: ['#d1a077','#4ead40','#26862a','#982ddf','#25da7e','#46a9ab','#b03ded',
                        // '#4115aa','#691f72','#04c27b','#c6ad38'],
                        backgroundColor: responseData.map(item => item.color),
                        data: responseData.map(item => item.total)
                    }                    
                ]
            };
            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')  
            var donutOptions     = {
                maintainAspectRatio : false,
                responsive : true,
                legend: {
                  display: false
                }
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var donutChart = new Chart(donutChartCanvas, {
                type: 'pie',
                data: me.chartData,
                options: donutOptions      
            })
          
        })
        .catch(function(error) {
          console.log(error);
        });
    },

  },
  mounted() {    
    let me = this;
    me.ingreso_sabor(this.FechaInicial, this.FechaFinal);




      $(function () {
      

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
         borderColor: "#ff0000 ",
        fill: false,  
          data                : [28, 48, 40, 19, 86, 27, 120]
        },
        {
          label               : 'Electronics',
         borderColor: "#e8c3b9",
        fill: false,
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
        {
          label               : 'Silvio',
         borderColor: "#f045c2",
        fill: false,
          data                : [35, 51, 90, 11, 120,0 , 90]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : true,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      }
    }



    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = areaChartOptions
    var lineChartData = areaChartData


    var lineChart = new Chart(lineChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions 
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    // var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome', 
          'IE',
          'FireFox', 
          'Safari', 
          'Opera', 
          'Navigator', 
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    console.log(donutData);
    
    // var donutOptions     = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    // }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    // var donutChart = new Chart(donutChartCanvas, {
    //   type: 'doughnut',
    //   data: donutData,
    //   options: donutOptions      
    // })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartData = jQuery.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }


  })
  },

};
</script>




<style>
</style>