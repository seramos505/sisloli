<template>
  <main class="main" v-if="$can('listar-ingreso')">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Reportes</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card mt-3">
        <div class="card-header">
          <h3 class="float-left">
            <i class="fas fa-calculator"></i> Ingresos
          </h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Rango:</label>
                <div class="d-flex">
                  <div class="input-group mr-1">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="fechahora" />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="form-control-label" for="text-input">Sabor:</label>
                    <div>
                      <select class="form-control" v-model="idsabor">
                        <option value="0">Seleccione el Sabor</option>
                        <option
                          v-for="sabor in arraySabor"
                          :key="sabor.id"
                          :value="sabor.id"
                          v-text="sabor.nombre"
                        ></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="form-control-label" for="text-input">Tamaño:</label>
                    <div>
                      <select class="form-control" v-model="idtamano">
                        <option value="0">Seleccione el Tamaño</option>
                        <option
                          v-for="tamano in arrayTamano"
                          :key="tamano.id"
                          :value="tamano.id"
                          v-text="tamano.nombre"
                        ></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-sm-6 col-6">
                  <div class="info-box">
                    <span class="info-box-icon bg-info">
                      <i class="fab fa-product-hunt"></i>
                    </span>
                    <div class="info-box-content">
                      <span class="info-box-text">Productos</span>
                      <span class="info-box-number">{{TotalProd}}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
                <div class="col-sm-6 col-6">
                  <div class="info-box">
                    <span class="info-box-icon bg-success">
                      <i class="far fa-money-bill-alt"></i>
                    </span>
                    <div class="info-box-content">
                      <span class="info-box-text">Total Neto</span>
                      <span class="info-box-number">C$ {{TotalVenta}}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="form-group">
                <button
                  type="submit"
                  @click="listarIngreso(1,FechaInicial,FechaFinal,idtamano,idsabor)"
                  class="btn btn-success w-100"
                >
                  <i class="fas fa-search"></i> Buscar
                </button>
              </div>
            </div>
          </div>
          <cargando v-if="loading"></cargando>
          <div v-else>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="thead-dark">
                  <tr>
                    <th>Orden Id</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Relleno</th>
                    <th>Combinado</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(ingreso) in arrayIngresos" :key="ingreso.id">
                    <td v-text="ingreso.orden"></td>
                    <td v-text="ingreso.producto"></td>
                    <td v-text="ingreso.precio"></td>
                    <td v-text="ingreso.cantidad"></td>
                    <td v-text="ingreso.descuento"></td>
                    <td>
                      <template v-if="ingreso.relleno">
                        <span class="badge badge-success">Si</span>
                      </template>
                      <template v-else>
                        <span class="badge badge-danger">No</span>
                      </template>
                    </td>
                    <td>
                      <template v-if="ingreso.combinado">
                        <span class="badge badge-info">{{ingreso.sabor}}</span>
                      </template>
                      <template v-else>
                        <span class="badge badge-danger">No</span>
                      </template>
                    </td>
                    <td>{{ingreso.precio*ingreso.cantidad-ingreso.descuento}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination
              :pagination="pagination"
              :cambiarPagina="cambiarPagina"
              :buscar="FechaInicial"
              :criterio="FechaFinal"
            ></pagination>
          </div>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
  </main>
  <main class="main" v-else>No tiene acceso</main>
</template>


<script>
export default {
  data() {
    return {
      arrayIngresos: [],
      arrayTamano: [],
      arraySabor: [],
      TotalVenta: 0.0,
      TotalProd: 0,
      idtamano: 0,
      idsabor: 0,
      FechaInicial: moment().format("YYYY-MM-DD 08:00:00"),
      FechaFinal: moment().format("YYYY-MM-DD 20:00:00"),
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      loading: true
    };
  },

  methods: {
    listarIngreso(page, FechaInicial, FechaFinal, idtamano, idsabor) {
      let me = this;
      me.loading = true;
      var url =
        "ingreso/fecha?page=" +
        page +
        "&FechaInicial=" +
        FechaInicial +
        "&FechaFinal=" +
        FechaFinal +
        "&idtamano=" +
        idtamano +
        "&idsabor=" +
        idsabor;

      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayIngresos = respuesta.ingresos.data;
          me.pagination = respuesta.pagination;
          me.TotalVenta = respuesta.totales.TotalVenta;
          me.TotalProd = respuesta.totales.TotalProd;
        })
        .catch(function(error) {
          console.log(error);
        })
        .finally(() => (me.loading = false));
    },
    selectTamano() {
      let me = this;
      var url = "tamano/selectTamano";
      axios
        .get(url)
        .then(function(response) {
          //console.log(response);
          var respuesta = response.data;
          me.arrayTamano = respuesta.tamanos;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    selectSabor() {
      let me = this;
      var url = "sabor/selectSabor";
      axios
        .get(url)
        .then(function(response) {
          //console.log(response);
          var respuesta = response.data;
          me.arraySabor = respuesta.sabores;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    cambiarPagina(page, FechaInicial, FechaFinal) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarIngreso(page, FechaInicial, FechaFinal, me.idtamano, me.idsabor);
    }
  },
  mounted() {
    this.selectSabor();
    this.selectTamano();
    this.listarIngreso(1, this.FechaInicial, this.FechaFinal, 0, 0);
  },
  updated() {
    //Date range picker with time picker
    let me = this;
    $("#fechahora").daterangepicker(
      {
        timePicker: true,
        timePickerIncrement: 15,
        startDate: moment(me.FechaInicial).format("DD/MM/YYYY 08:00:00"),
        endDate: moment(me.FechaFinal).format("DD/MM/YYYY 20:00:00"),
        opens: "left",
        applyButtonClasses: "btn-success",
        cancelClass: "btn-danger",
        locale: {
          format: "DD/MM/YYYY hh:mm A",
          cancelLabel: "Cancelar",
          applyLabel: "Aplicar"
        }
      },
      function(start, end, label) {
        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        me.FechaInicial = start.format("YYYY-MM-DD HH:mm:ss");
        me.FechaFinal = end.format("YYYY-MM-DD HH:mm:ss");
      }
    );
    $("#fechahora").on("apply.daterangepicker", function(ev, picker) {
      me.listarIngreso(
        1,
        me.FechaInicial,
        me.FechaFinal,
        me.idtamano,
        me.idsabor
      );
    });
  }
};
</script>
