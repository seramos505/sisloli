<template>
  <main class="main" v-if="$can('listar-producto')">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Catalogo</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <h3 class="float-left">
            <i class="fab fa-product-hunt"></i> Productos
          </h3>
          <button
            v-if="$can('nuevo-producto')"
            type="button"
            @click="abrirModal('producto','registrar')"
            class="btn btn-success float-right"
          >
            <i class="fas fa-plus-circle"></i>&nbsp;Nuevo Producto
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="criterio">
                  <option value="nombre">Nombre</option>
                  <option value="descripcion">Descripción</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarproducto(1,buscar,criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarproducto(1,buscar,criterio)"
                  class="btn btn-primary"
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
                    <th colspan="2">Opciones</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Tamaño</th>
                    <th>Sabor</th>
                    <th>Precio Venta</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="producto in arrayProducto" :key="producto.id">
                    <td style="width: 10px;">
                      <button
                        v-if="$can('editar-producto')"
                        type="button"
                        @click="abrirModal('producto','actualizar',producto)"
                        class="btn btn-warning btn-sm"
                        title="Editar Producto"
                      >
                        <i class="fas fa-edit"></i>
                      </button>
                    </td>
                    <td style="width: 10px;">
                      <template v-if="producto.condicion">
                        <button
                          v-if="$can('desactivar-producto')"
                          type="button"
                          class="btn btn-danger btn-sm"
                          @click="desactivarproducto(producto.id)"
                          title="Desactivar producto"
                        >
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </template>
                      <template v-else>
                        <button
                          v-if="$can('activar-producto')"
                          type="button"
                          class="btn btn-info btn-sm"
                          @click="activarproducto(producto.id)"
                          title="Activar producto"
                        >
                          <i class="fas fa-check"></i>
                        </button>
                      </template>
                    </td>
                    <td v-text="producto.nombre"></td>
                    <td v-text="producto.nombre_categoria"></td>
                    <td v-text="producto.nombre_tamano"></td>
                    <td v-text="producto.nombre_sabor"></td>
                    <td v-text="producto.precio_venta"></td>
                    <td v-text="producto.descripcion"></td>
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
            <pagination
              :pagination="pagination"
              :cambiarPagina="cambiarPagina"
              :buscar="buscar"
              :criterio="criterio"
            ></pagination>
          </div>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" id="modalCU">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <i class="fas fa-times-circle"></i>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">
                  Categoría
                  <i class="required-entry">*</i>
                </label>
                <div class="col-md-9">
                  <select class="form-control" v-model="idcategoria">
                    <option value="0" disabled>Seleccione la Categoría</option>
                    <option
                      v-for="categoria in arrayCategoria"
                      :key="categoria.id"
                      :value="categoria.id"
                      v-text="categoria.nombre"
                    ></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">
                  Tamaño
                  <i class="required-entry">*</i>
                </label>
                <div class="col-md-9">
                  <select class="form-control" v-model="idtamano">
                    <option value="0" disabled>Seleccione el Tamaño</option>
                    <option
                      v-for="tamano in arrayTamano"
                      :key="tamano.id"
                      :value="tamano.id"
                      v-text="tamano.nombre"
                    ></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">
                  Sabor
                  <i class="required-entry">*</i>
                </label>
                <div class="col-md-9">
                  <select class="form-control" v-model="idsabor">
                    <option value="0" disabled>Seleccione el Sabor</option>
                    <option
                      v-for="sabor in arraySabor"
                      :key="sabor.id"
                      :value="sabor.id"
                      v-text="sabor.nombre"
                    ></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 control-label" for="text-input">
                  Nombre:
                  <i class="required-entry">*</i>
                </label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="nombre"
                    class="form-control"
                    placeholder="Nombre del Producto"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">
                  Precio Venta
                  <i class="required-entry">*</i>
                </label>
                <div class="col-md-9">
                  <input type="number" v-model="precio_venta" class="form-control" placeholder />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 control-label" for="text-input">Descripción:</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="descripcion"
                    class="form-control"
                    placeholder="Ingrese descripción"
                  />
                </div>
              </div>
              <div v-show="errorProducto" class="form-group row div-error">
                <div class="text-center text-error">
                  <u>
                    <li v-for="error in errorMostrarMsjProducto" :key="error" v-text="error"></li>
                  </u>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-info" @click="cerrarModal()">
              <i class="fas fa-times-circle"></i> Cerrar
            </button>
            <button
              type="button"
              v-if="tipoAccion==1"
              class="btn btn-success"
              @click="registrarproducto()"
            >
              <i class="fas fa-save"></i> Guardar
            </button>
            <button
              type="button"
              v-if="tipoAccion==2"
              class="btn btn-primary"
              @click="actualizarproducto()"
            >
              <i class="fas fa-save"></i> Actualizar
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
  </main>
  <main class="main" v-else>No tiene acceso</main>
</template>

<script>
export default {
  data() {
    return {
      producto_id: 0,
      idcategoria: 0,
      nombre_categoria: "",
      idtamano: 0,
      nombre_sabor: "",
      idsabor: 0,
      nombre_sabor: "",
      nombre: "",
      precio_venta: 0,
      descripcion: "",
      arrayProducto: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorProducto: 0,
      errorMostrarMsjProducto: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      criterio: "nombre",
      buscar: "",
      arrayCategoria: [],
      arrayTamano: [],
      arraySabor: [],
      loading: true
    };
  },
  methods: {
    listarproducto(page, buscar, criterio) {
      let me = this;
      me.loading= true;
      var url =
        "producto/listar?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayProducto = respuesta.productos.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        })
        .finally(() => (me.loading = false));
    },
    selectCategoria() {
      let me = this;
      var url = "categoria/selectCategoria";
      axios
        .get(url)
        .then(function(response) {
          //console.log(response);
          var respuesta = response.data;
          me.arrayCategoria = respuesta.categorias;
        })
        .catch(function(error) {
          console.log(error);
        });
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
    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarproducto(page, buscar, criterio);
    },
    registrarproducto() {
      if (this.validarproducto()) {
        return;
      }

      let me = this;

      axios
        .post("producto/registrar", {
          idcategoria: this.idcategoria,
          idtamano: this.idtamano,
          idsabor: this.idsabor,
          nombre: this.nombre,
          precio_venta: this.precio_venta,
          descripcion: this.descripcion
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarproducto(me.pagination.current_page, me.buscar, me.criterio);
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: "success",
            title: "El producto ha sido Creado con Exito"
          });
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizarproducto() {
      if (this.validarproducto()) {
        return;
      }

      let me = this;

      axios
        .put("producto/actualizar", {
          idcategoria: this.idcategoria,
          idtamano: this.idtamano,
          idsabor: this.idsabor,
          nombre: this.nombre,
          precio_venta: this.precio_venta,
          descripcion: this.descripcion,
          id: this.producto_id
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarproducto(me.pagination.current_page, me.buscar, me.criterio);

          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: "success",
            title: "El producto ha sido Actualizado con Exito"
          });
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    desactivarproducto(id) {
      Swal.fire({
        title: "Estas Seguro?",
        text: "Desactivar este Producto!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger mr-3",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("producto/desactivar", {
              id: id
            })
            .then(function(response) {
              me.listarproducto(
                me.pagination.current_page,
                me.buscar,
                me.criterio
              );
              Swal.fire(
                "Desactivado!",
                "El registro ha sido desactivado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === Swal.DismissReason.cancel
        ) {
        }
      });
    },
    activarproducto(id) {
      Swal.fire({
        title: "Estas Seguro?",
        text: "Activar este Producto!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger mr-3",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("producto/activar", {
              id: id
            })
            .then(function(response) {
              me.listarproducto(
                me.pagination.current_page,
                me.buscar,
                me.criterio
              );
              Swal.fire(
                "Activado!",
                "El registro ha sido activado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === Swal.DismissReason.cancel
        ) {
        }
      });
    },
    validarproducto() {
      this.errorProducto = 0;
      this.errorMostrarMsjProducto = [];

      if (this.idcategoria == 0)
        this.errorMostrarMsjProducto.push("Seleccione una categoría.");
      if (this.idtamano == 0)
        this.errorMostrarMsjProducto.push("Seleccione un Tamano.");
      if (this.idsabor == 0)
        this.errorMostrarMsjProducto.push("Seleccione un Sabor.");
      if (!this.nombre)
        this.errorMostrarMsjProducto.push(
          "El nombre del Producto no puede estar vacío."
        );
      if (!this.precio_venta)
        this.errorMostrarMsjProducto.push(
          "El precio venta del artículo debe ser un número y no puede estar vacío."
        );

      if (this.errorMostrarMsjProducto.length) this.errorProducto = 1;

      return this.errorProducto;
    },
    cerrarModal() {
      this.tituloModal = "";
      this.idcategoria = 0;
      this.nombre_categoria = "";
      this.idtamano = 0;
      this.nombre_tamano = "";
      this.idsabor = 0;
      this.nombre_sabor = "";
      this.nombre = "";
      this.precio_venta = 0;
      this.descripcion = "";
      this.errorProducto = 0;
      this.errorMostrarMsjProducto = [];
      $("#modalCU").modal("hide");
    },
    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "producto": {
          switch (accion) {
            case "registrar": {
              this.tituloModal = "Registrar Producto";
              this.idcategoria = 0;
              this.nombre_categoria = "";
              this.idtamano = 0;
              this.nombre_tamano = "";
              this.idsabor = 0;
              this.nombre_sabor = "";
              this.nombre = "";
              this.precio_venta = 0;
              this.descripcion = "";
              this.tipoAccion = 1;
              $("#modalCU").modal("show");
              break;
            }
            case "actualizar": {
              //console.log(data);
              this.tituloModal = "Actualizar Producto";
              this.tipoAccion = 2;
              this.producto_id = data["id"];
              this.idcategoria = data["idcategoria"];
              this.idtamano = data["idtamano"];
              this.idsabor = data["idsabor"];
              this.nombre = data["nombre"];
              this.precio_venta = data["precio_venta"];
              this.descripcion = data["descripcion"];
              $("#modalCU").modal("show");
              break;
            }
          }
        }
      }
      this.selectCategoria();
      this.selectTamano();
      this.selectSabor();
    }
  },
  mounted() {
    this.listarproducto(1, this.buscar, this.criterio);
  }
};
</script>

