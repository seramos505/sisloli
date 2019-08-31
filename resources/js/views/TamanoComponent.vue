<template>
  <main class="main" v-if="$can('listar-tamano')">
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <h3 class="float-left">
            <i class="fas fa-th-list"></i> Tamaños
          </h3>
          <button
            v-if="$can('nuevo-tamano')"
            type="button"
            @click="abrirModal('tamano','registrar')"
            class="btn btn-success float-right"
          >
            <i class="fas fa-plus-circle"></i>&nbsp;Nuevo tamaño
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
                  @keyup.enter="listartamano(1,buscar,criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listartamano(1,buscar,criterio)"
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
                  <th colspan="2">Opciones</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="tamano in arraytamano" :key="tamano.id">
                  <td style="width: 10px;">
                    <button
                      v-if="$can('editar-tamano')"
                      type="button"
                      @click="abrirModal('tamano','actualizar',tamano)"
                      class="btn btn-warning btn-sm"
                      title="Editar tamano"
                    >
                      <i class="fas fa-edit"></i>
                    </button>
                  </td>
                  <td style="width: 10px;">
                    <template v-if="tamano.condicion">
                      <button
                        v-if="$can('desactivar-tamano')"
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="desactivartamano(tamano.id)"
                        title="Desactivar tamano"
                      >
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </template>
                    <template v-else>
                      <button
                        v-if="$can('activar-tamano')"
                        type="button"
                        class="btn btn-info btn-sm"
                        @click="activartamano(tamano.id)"
                        title="Activar tamano"
                      >
                        <i class="fas fa-check"></i>
                      </button>
                    </template>
                  </td>
                  <td v-text="tamano.nombre"></td>
                  <td v-text="tamano.descripcion"></td>
                  <td>
                    <div v-if="tamano.condicion">
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
          <pagination :pagination="pagination" :cambiarPagina="cambiarPagina" :buscar="buscar" :criterio="criterio"></pagination>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" :class="{'show mostrar' : modal}">
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
              <div class="form-group row required">
                <label class="col-md-3 control-label" for="text-input">Nombre:</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="nombre"
                    class="form-control"
                    placeholder="Nombre de tamano"
                  />
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
              <div v-show="errortamano" class="form-group row div-error">
                <div class="text-center text-error">
                  <div v-for="error in errorMostrarMsjtamano" :key="error" v-text="error"></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-info" @click="cerrarModal()"><i class="fas fa-times-circle"></i> Cerrar</button>
            <button
              type="button"
              v-if="tipoAccion==1"
              class="btn btn-success"
              @click="registrartamano()"
            ><i class="fas fa-save"></i> Guardar</button>
            <button
              type="button"
              v-if="tipoAccion==2"
              class="btn btn-primary"
              @click="actualizartamano()"
            ><i class="fas fa-save"></i> Actualizar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
  </main>
  <main class="main" v-else>
    No tiene acceso
  </main> 
</template>

<script>
export default {
  data() {
    return {
      tamano_id: 0,
      nombre: "",
      descripcion: "",
      arraytamano: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errortamano: 0,
      errorMostrarMsjtamano: [],
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
      buscar: ""
    };
  },
  methods: {
    listartamano(page, buscar, criterio) {
      let me = this;
      var url =
        "tamano/listar?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arraytamano = respuesta.tamanos.data;
          me.pagination = respuesta.pagination;
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
      me.listartamano(page, buscar, criterio);
    },
    registrartamano() {
      if (this.validartamano()) {
        return;
      }

      let me = this;

      axios
        .post("tamano/registrar", {
          nombre: this.nombre,
          descripcion: this.descripcion
        })
        .then(function(response) {
          me.cerrarModal();
          me.listartamano(1, "", "nombre");
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'El tamano ha sido Creado con Exito'
          })
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizartamano() {
      if (this.validartamano()) {
        return;
      }

      let me = this;

      axios
        .put("tamano/actualizar", {
          nombre: this.nombre,
          descripcion: this.descripcion,
          id: this.tamano_id
        })
        .then(function(response) {
          me.cerrarModal();
          me.listartamano(1, "", "nombre");
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'El tamano ha sido Actualizado con Exito'
          })
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    desactivartamano(id) {
      Swal.fire({
        title: 'Estas Seguro?',
        text: "Desactivar este tamano!",
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
            .put("tamano/desactivar", {
              id: id
            })
            .then(function(response) {
              me.listartamano(1, "", "nombre");
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
          result.dismiss === Swal.fire.DismissReason.cancel
        ) {
        }
      });
    },
    activartamano(id) {
      Swal.fire({
        title: 'Estas Seguro?',
        text: "Activar este tamano!",
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
            .put("tamano/activar", {
              id: id
            })
            .then(function(response) {
              me.listartamano(1, "", "nombre");
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
          result.dismiss === Swal.fire.DismissReason.cancel
        ) {
        }
      });
    },
    validartamano() {
      this.errortamano = 0;
      this.errorMostrarMsjtamano = [];

      if (!this.nombre)
        this.errorMostrarMsjtamano.push(
          "El nombre del no puede estar vacío."
        );

      if (this.errorMostrarMsjtamano.length) this.errortamano = 1;

      return this.errortamano;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.nombre = "";
      this.descripcion = "";
      this.errortamano = 0;
      this.errorMostrarMsjtamano = [];
    },
    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "tamano": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar tamano";
              this.nombre = "";
              this.descripcion = "";
              this.tipoAccion = 1;
              break;
            }
            case "actualizar": {
              //console.log(data);
              this.modal = 1;
              this.tituloModal = "Actualizar tamano";
              this.tipoAccion = 2;
              this.tamano_id = data["id"];
              this.nombre = data["nombre"];
              this.descripcion = data["descripcion"];
              break;
            }
          }
        }
      }
    }
  },
  mounted() {
    this.listartamano(1, this.buscar, this.criterio);
  }
};
</script>

