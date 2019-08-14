<template>
  <main class="main">
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <h3 class="float-left">
            <i class="fas fa-cart-plus"></i> Ordenes
          </h3>
          <button type="button" @click="mostrarDetalle()" class="btn btn-success float-right"
          
          v-bind:disabled="listado==0">
            <i class="fas fa-plus-circle"></i>&nbsp;Nueva Orden
          </button>
        </div>
        <!-- Listado-->
        <template v-if="listado==1">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-md-6">
                <div class="input-group">
                  <select class="form-control col-md-3" v-model="criterio">
                    <option value="id">id</option>
                  </select>
                  <input
                    type="text"
                    v-model="buscar"
                    @keyup.enter="listarOrden(1,buscar,criterio)"
                    class="form-control"
                    placeholder="Texto a buscar"
                  />
                  <button
                    type="submit"
                    @click="listarOrden(1,buscar,criterio)"
                    class="btn btn-primary"
                  >
                    <i class="fa fa-search"></i> Buscar
                  </button>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="thead-dark">
                  <tr>
                    <th colspan="3">Opciones</th>
                    <th>Usuario</th>
                    <th>Fecha Hora</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="orden in arrayOrden" :key="orden.id">
                    <td style="width: 10px;">
                      <button
                        type="button"
                        @click="verOrden(orden.id)"
                        class="btn btn-success btn-sm"
                      >
                        <i class="fas fa-eye"></i>
                      </button>
                      </td>
                      <td style="width: 10px;">
                      <button
                        type="button"
                        @click="pdfOrden(orden.id)"
                        class="btn btn-info btn-sm"
                      >
                        <i class="fas fa-file-pdf"></i>
                      </button>
                      </td>
                      <td style="width: 10px;">
                      <template v-if="orden.estado=='Registrado'">
                        <button
                          type="button"
                          class="btn btn-danger btn-sm"
                          @click="desactivarOrden(orden.id)"
                        >
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </template>
                    </td>
                    <td v-text="orden.name"></td>
                    <td v-text="fecha(orden.fecha_hora)"></td>
                    <td v-text="orden.total"></td>
                    <td v-text="orden.estado"></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <nav>
              <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page > 1">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)"
                  >Ant</a>
                </li>
                <li
                  class="page-item"
                  v-for="page in pagesNumber"
                  :key="page"
                  :class="[page == isActived ? 'active' : '']"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="cambiarPagina(page,buscar,criterio)"
                    v-text="page"
                  ></a>
                </li>
                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
                  >Sig</a>
                </li>
              </ul>
            </nav>
          </div>
        </template>
        <!--Fin Listado-->
        <!-- Detalle-->
        <template v-else-if="listado==0">
          <div class="card-body">
            <div class="form-group row border">
              <div class="col-md-9">
                  <div class="form-group">
                      <label for="">Cliente(*)</label>
                     
                      <select2 :options="arrayCliente" v-model="idcliente">
                              
                      </select2>
                  </div>
              </div>
              <div class="col-md-3">
                  <label for="">Impuesto(*)</label>
                  <input type="text" class="form-control" v-model="impuesto">
              </div>
              <div class="col-md-12">
                <div v-show="errorOrden" class="form-group row div-error">
                  <div class="text-center text-error">
                    <div v-for="error in errorMostrarMsjOrden" :key="error" v-text="error"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row border py-2">
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label>
                    Producto
                    <span style="color: red;">*</span>
                  </label>
                  <div class="d-flex">
                    <input
                      type="text"
                      class="form-control"
                      v-model="codigo"
                      @keyup.enter="buscarProducto()"
                      placeholder="Ingrese Codigo Producto"
                    />
                    <button @click="abrirModal()" class="btn btn-primary">...</button>
                  </div>
                    <input type="text" readonly class="form-control" v-model="producto" />                  
                </div>
              </div>
              <div class="col-4 col-md-2">
                <div class="form-group">
                  <label>
                    Precio
                    <span style="color: red;">*</span>
                  </label>
                  <input type="number" value="0" step="any" class="form-control" v-model="precio" />
                </div>
              </div>
              <div class="col-4 col-md-2">
                <div class="form-group">
                  <label>
                    Cantidad
                    <span style="color: red;">*</span>
                  </label>
                  <input type="number" value="0" class="form-control" v-model="cantidad" />
                </div>
              </div>
              <div class="col-4 col-md-2">
                <div class="form-group">
                  <label>Descuento</label>
                  <input type="number" value="0" class="form-control" v-model="descuento" />
                </div>
              </div>
              <div class="col-12 col-md-2">
                <div class="form-group">
                  <label class="d-none d-sm-inline-block">&nbsp;</label>
                  <button @click="agregarDetalle()" class="btn btn-success w-100">
                    <i class="fas fa-plus-circle"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                  <thead class="thead-dark">
                    <tr>
                      <th></th>
                      <th>Producto</th>
                      <th>Precio</th>
                      <th>Cant.</th>
                      <th>Desc.</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody v-if="arrayDetalle.length">
                    <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                      <td style="width: 10px;">
                        <button
                          @click="eliminarDetalle(index)"
                          type="button"
                          class="btn btn-danger btn-sm"
                        >
                          <i class="fas fa-minus-circle"></i>
                        </button>
                      </td>
                      <td v-text="detalle.producto"></td>
                      <td>
                        <input v-model="detalle.precio" type="number" class="form-control" />
                      </td>
                      <td>
                        <input v-model="detalle.cantidad" type="number" class="form-control" />
                      </td>
                      <td>
                        <span
                          style="color:red;"
                          v-show="detalle.descuento>(detalle.precio*detalle.cantidad)"
                        >Descuento superior</span>
                        <input v-model="detalle.descuento" type="number" class="form-control" />
                      </td>
                      <td>{{detalle.precio*detalle.cantidad-detalle.descuento}}</td>
                    </tr>
                    <tr style="background-color: #CEECF5;">
                      <td colspan="5" align="right">
                        <strong>Total Parcial:</strong>
                      </td>
                      <td>C$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color: #CEECF5;">
                      <td colspan="5" align="right">
                        <strong>Total Impuesto:</strong>
                      </td>
                      <td>C$ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color: #CEECF5;">
                      <td colspan="5" align="right">
                        <strong>Total Neto:</strong>
                      </td>
                      <td>C$ {{total=calcularTotal}}</td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="6">No hay productos agregados</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="registrarOrden()"
                >Registrar Orden</button>
              </div>
            </div>
          </div>
        </template>
        <!-- Fin Detalle-->
        <!--Ver ingreso-->
        <template v-else-if="listado==2">
          <div class="card-body">
            <div class="form-group row border">
              <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                  <thead class="thead-dark">
                    <tr>
                      <th>Producto</th>
                      <th>Precio</th>
                      <th>Cantidad</th>
                      <th>Descuento</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody v-if="arrayDetalle.length">
                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                      <td v-text="detalle.producto"></td>
                      <td v-text="detalle.precio"></td>
                      <td v-text="detalle.cantidad"></td>
                      <td v-text="detalle.descuento"></td>
                      <td>{{detalle.precio*detalle.cantidad-detalle.descuento}}</td>
                    </tr>
                    <tr style="background-color: #CEECF5;">
                      <td colspan="4" align="right">
                        <strong>Total Parcial:</strong>
                      </td>
                      <td>C$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color: #CEECF5;">
                      <td colspan="4" align="right">
                        <strong>Total Impuesto:</strong>
                      </td>
                      <td>C$ {{totalImpuesto=(total*impuesto).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color: #CEECF5;">
                      <td colspan="4" align="right">
                        <strong>Total Neto:</strong>
                      </td>
                      <td>C$ {{total}}</td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="5">No hay productos agregados</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
              </div>
            </div>
          </div>
        </template>
        <!--Fin ver ingreso-->
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" id="modalCU">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <i class="fas fa-times-circle"></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <div class="col-md-6">
                <div class="input-group">
                  <select class="form-control col-md-3" v-model="criterioA">
                    <option value="nombre">Nombre</option>
                    <option value="descripcion">Descripción</option>
                    <option value="codigo">Código</option>
                  </select>
                  <input
                    type="text"
                    v-model="buscarA"
                    @keyup.enter="listarProducto(buscarA,criterioA)"
                    class="form-control"
                    placeholder="Texto a buscar"
                  />
                  <button
                    type="submit"
                    @click="listarProducto(buscarA,criterioA)"
                    class="btn btn-primary"
                  >
                    <i class="fas fa-search"></i> Buscar
                  </button>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="thead-dark">
                  <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="producto in arrayProducto" :key="producto.id">
                    <td style="width: 10px;">
                      <button
                        type="button"
                        @click="agregarDetalleModal(producto)"
                        class="btn btn-success btn-sm"
                      >
                        <i class="fas fa-cart-plus"></i>
                      </button>
                    </td>
                    <td v-text="producto.nombre"></td>
                    <td v-text="producto.nombre_categoria"></td>
                    <td v-text="producto.precio_venta"></td>
                    <td>
                      <div v-if="producto.condicion">
                        <span class="badge badge-success">Activo</span>
                      </div>
                      <div v-else>
                        <span class="badge badge-danger">Desactivado</span>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" @click="cerrarModal()">
              <i class="fas fa-times-circle"></i> Cerrar
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
  </main>
</template>

<script>
export default {
  data() {
    return {
      orden_id: 0,
      idcliente: 1,
      cliente: "",
      impuesto: 0.15,
      total: 0.0,
      totalImpuesto: 0.0,
      totalParcial: 0.0,
      arrayOrden: [],
      arrayCliente: [],
      arrayDetalle: [],
      listado: 1,
      tituloModal: "",
      errorOrden: 0,
      errorMostrarMsjOrden: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      criterio: "id",
      buscar: "",
      criterioA: "nombre",
      buscarA: "",
      arrayProducto: [],
      idproducto: 0,
      codigo: "",
      producto: "",
      precio: 0,
      cantidad: 0,
      descuento: 0
    };
  },

  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },

    //Calcula los elementos de la paginación
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },

    calcularTotal: function() {
      var resultado = 0.0;
      for (var i = 0; i < this.arrayDetalle.length; i++) {
        resultado =
          resultado +
          (this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad -
            this.arrayDetalle[i].descuento);
      }
      return resultado;
    }
  },
  methods: {
    fecha(date){
      //return moment(date).format('LLL')
      //return moment.locale("de").format('LLL');
      moment.locale('es');
      return moment(date).format('DD/MM/YYYY hh:mm a')      
    },
    listarOrden(page, buscar, criterio) {
      let me = this;
      var url =
        "orden/listar?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayOrden = respuesta.ordenes.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    selectCliente() {
      let me = this;
      var url = "cliente/selectCliente";
      axios
        .get(url)
        .then(function(response) {
          //console.log(response);
          //var respuesta = response.data;
          me.arrayCliente = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    
    /*selectCliente(search, loading) {
      let me = this;
      loading(true);
      var url = "cliente/selectCliente?filtro=" + search;
      axios
        .get(url)
        .then(function(response) {
          //console.log(response);
          let respuesta = response.data;
          q: search;
          me.arrayCliente = respuesta.clientes;
          loading(false);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getDatosCliente(val1) {
      let me = this;
      me.loading = true;
      me.idcliente = val1.id;
    },*/

    buscarProducto() {
      let me = this;
      var url = "producto/buscarProductoOrden?filtro=" + me.codigo;

      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayProducto = respuesta.productos;

          if (me.arrayProducto.length > 0) {
            me.producto = me.arrayProducto[0]["nombre"];
            me.idproducto = me.arrayProducto[0]["id"];
            me.precio = me.arrayProducto[0]["precio_venta"];
            me.cantidad = 1;
          } else {
            me.producto = "No existe este producto";
            me.idproducto = 0;
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    pdfOrden(id) {
      window.open("orden/pdf/" + id, "_blank");
    },
    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarOrden(page, buscar, criterio);
    },
    encuentra(id) {
      var sw = 0;
      for (var i = 0; i < this.arrayDetalle.length; i++) {
        if (this.arrayDetalle[i].idproducto == id) {
          sw = true;
        }
      }
      return sw;
    },
    eliminarDetalle(index) {
      let me = this;
      me.arrayDetalle.splice(index, 1);
    },
    agregarDetalle() {
      let me = this;
      if (me.idproducto == 0 || me.cantidad == 0 || me.precio == 0) {
      } else {
        if (me.encuentra(me.idproducto)) {
          Swal.fire({
            type: "error",
            title: "Error...",
            text: "Este Producto ya se encuentra agregado!"
          });
        } else {
          me.arrayDetalle.push({
            idproducto: me.idproducto,
            producto: me.producto,
            cantidad: me.cantidad,
            precio: me.precio,
            descuento: me.descuento
          });
          me.codigo = "";
          me.idproducto = 0;
          me.producto = "";
          me.cantidad = 0;
          me.precio = 0;
          me.descuento = 0;
        }
      }
    },
    agregarDetalleModal(data = []) {
      let me = this;
      if (me.encuentra(data["id"])) {
        Swal.fire({
          type: "error",
          title: "Error...",
          text: "Este Producto ya se encuentra agregado!"
        });
      } else {
        me.arrayDetalle.push({
          idproducto: data["id"],
          producto: data["nombre"],
          cantidad: 1,
          precio: data["precio_venta"],
          descuento: 0
        });
      }
    },
    listarProducto(buscar, criterio) {
      let me = this;
      var url =
        "producto/listarProductoOrden?buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayProducto = respuesta.productos.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    registrarOrden() {
      if (this.validarOrden()) {
        return;
      }

      let me = this;

      axios
        .post("orden/registrar", {
          impuesto: this.impuesto,
          total: this.total,
          data: this.arrayDetalle
        })
        .then(function(response) {
          me.listado = 1;
          me.listarOrden(1, "", "fecha_hora");
          me.total = 0.0;
          me.idproducto = 0;
          me.producto = "";
          me.cantidad = 0;
          me.precio = 0;
          me.codigo = "";
          me.descuento = 0;
          me.arrayDetalle = [];
          //window.open("orden/pdf/" + response.data.id);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    validarOrden() {
      let me = this;
      me.errorOrden = 0;
      me.errorMostrarMsjOrden = [];
      var art;

      if (!me.impuesto)
        me.errorMostrarMsjOrden.push("Ingrese el impuesto de compra");
      if (me.arrayDetalle.length <= 0)
        me.errorMostrarMsjOrden.push("Ingrese detalles");

      if (me.errorMostrarMsjOrden.length) me.errorOrden = 1;

      return me.errorOrden;
    },
    mostrarDetalle() {
      let me = this;
      me.listado = 0;
      me.impuesto = 0.15;
      me.total = 0.0;
      me.idproducto = 0;
      me.producto = "";
      me.cantidad = 0;
      me.precio = 0;
      me.arrayDetalle = [];
      this.selectCliente();
    },
    ocultarDetalle() {
      this.listado = 1;
    },
    verOrden(id) {
      let me = this;
      me.listado = 2;

      //Obtener datos del ingreso
      var arrayOrdenT = [];
      var url = "orden/obtenerCabecera?id=" + id;

      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          arrayOrdenT = respuesta.orden;

          /*me.cliente = arrayOrdenT[0]["nombre"];
          me.tipo_comprobante = arrayOrdenT[0]["tipo_comprobante"];
          me.serie_comprobante = arrayOrdenT[0]["serie_comprobante"];
          me.num_comprobante = arrayOrdenT[0]["num_comprobante"];*/
          me.impuesto = arrayOrdenT[0]["impuesto"];
          me.total = arrayOrdenT[0]["total"];
        })
        .catch(function(error) {
          console.log(error);
        });

      //obtener datos de los detalles
      var url = "orden/obtenerDetalles?id=" + id;

      axios
        .get(url)
        .then(function(response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayDetalle = respuesta.detalles;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    cerrarModal() {
      //this.modal = 0;
      this.tituloModal = "";
      $("#modalCU").modal("hide");
    },
    abrirModal() {
      this.arrayProducto = [];
      //this.modal = 1;
      this.tituloModal = "Seleccione los productos que desee";
      $("#modalCU").modal("show");
    },

    desactivarOrden(id) {
      Swal.fire({
        title: "Esta seguro de anular esta orden?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("orden/desactivar", {
              id: id
            })
            .then(function(response) {
              me.listarOrden(1, "", "fecha_hora");
              Swal.fire(
                "Anulado!",
                "La orden ha sido anulado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === Swal.fire.DismissReason.cancel
        ) {
        }
      });
    }
  },
  mounted() {
    this.listarOrden(1, this.buscar, this.criterio);
  }
};
</script>

