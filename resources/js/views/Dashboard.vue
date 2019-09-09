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
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class="chart-responsive">
                      <canvas id="saborChart" height="250"></canvas>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <ul class="chart-legend clearfix">
                      <li v-for="(item,index) in arrayingreso_sabor" :key="index">
                        <i class="fas fa-ice-cream" :style="{color:item.color}"></i>
                        {{item.sabor}}:
                        <span
                          class="badge text-white"
                          :style="{'background-color':item.color}"
                        >{{item.total}}</span>
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
          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- PIE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Venta por Tamano</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="tamanoChart" style="height:250px; min-height:250px"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </main>
</template>

<script>
export default {
  data() {
    return {
      arrayingreso_sabor: [],
      saborchartData: "",
      FechaInicial: moment()
        .subtract(6, "days")
        .format("YYYY-MM-DD HH:mm:ss"),
      FechaFinal: moment().format("YYYY-MM-DD HH:mm:ss")
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
          me.saborchartData = {
            labels: responseData.map(item => item.sabor),
            datasets: [
              {
                label: "Sabor",
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
          var saborChartCanvas = $("#saborChart")
            .get(0)
            .getContext("2d");
          var saborOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
              display: false
            }
          };
          //Create pie or douhnut chart
          // You can switch between pie and douhnut using the method below.
          var saborChart = new Chart(saborChartCanvas, {
            type: "pie",
            data: me.saborchartData,
            options: saborOptions
          });
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    ingreso_tamano(FechaInicial, FechaFinal) {
      let me = this;
      var url =
        "grafico/ingreso_tamano?FechaInicial=" +
        FechaInicial +
        "&FechaFinal=" +
        FechaFinal;
      axios
        .get(url)
        .then(function(response) {
          var responseData = response.data;
          // me.arrayingreso_sabor = responseData;
          me.tamanochartData = {
            labels: responseData.map(item => item.tamano),
            datasets: [
              {
                label: "Tamano",
                backgroundColor: ["#f56954", "#00a65a", "#f39c12"],
                data: responseData.map(item => item.total)
              }
            ]
          };
          //-------------
          //- DONUT CHART -
          //-------------
          // Get context with jQuery - using jQuery's .get() method.
          var tamanoChartCanvas = $("#tamanoChart")
            .get(0)
            .getContext("2d");
          var tamanoOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
              display: true
            }
          };
          //Create pie or douhnut chart
          // You can switch between pie and douhnut using the method below.
          var tamanoChart = new Chart(tamanoChartCanvas, {
            type: "doughnut",
            data: me.tamanochartData,
            options: tamanoOptions
          });
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    let me = this;
    me.ingreso_sabor(this.FechaInicial, this.FechaFinal);
    me.ingreso_tamano(this.FechaInicial, this.FechaFinal);
  }
};
</script>

<style>
</style>