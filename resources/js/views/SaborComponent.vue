<template>
  <main class="main">
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <h3 class="float-left">
            <i class="fas fa-th-list"></i> Sabores
          </h3>
          <button
            type="button"
            @click="abrirModal('sabor','registrar')"
            class="btn btn-success float-right"
          >
            <i class="fas fa-plus-circle"></i>&nbsp;Nuevo Sabor
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
                  @keyup.enter="listarsabor(1,buscar,criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarsabor(1,buscar,criterio)"
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
                <tr v-for="sabor in arraySabor" :key="sabor.id">
                  <td style="width: 10px;">
                    <button
                      type="button"
                      @click="abrirModal('sabor','actualizar',sabor)"
                      class="btn btn-warning btn-sm"
                      title="Editar sabor"
                    >
                      <i class="fas fa-edit"></i>
                    </button>
                  </td>
                  <td style="width: 10px;">
                    <template v-if="sabor.condicion">
                      <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="desactivarsabor(sabor.id)"
                        title="Desactivar sabor"
                      >
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </template>
                    <template v-else>
                      <button
                        type="button"
                        class="btn btn-info btn-sm"
                        @click="activarsabor(sabor.id)"
                        title="Activar sabor"
                      >
                        <i class="fas fa-check"></i>
                      </button>
                    </template>
                  </td>
                  <td v-text="sabor.nombre"></td>
                  <td v-text="sabor.descripcion"></td>
                  <td>
                    <div v-if="sabor.condicion">
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
              <div class="form-group row ">
                <label class="col-md-3 control-label" for="text-input">Nombre: <i class="required-entry">*</i></label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="nombre"
                    class="form-control"
                    placeholder="Nombre de sabor"
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
              <div v-show="errorSabor" class="form-group row div-error">
                <div class="text-center text-error">
                  <div v-for="error in errorMostrarMsjSabor" :key="error" v-text="error"></div>
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
              @click="registrarsabor()"
            ><i class="fas fa-save"></i> Guardar</button>
            <button
              type="button"
              v-if="tipoAccion==2"
              class="btn btn-primary"
              @click="actualizarsabor()"
            ><i class="fas fa-save"></i> Actualizar</button>
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
      sabor_id: 0,
      nombre: "",
      descripcion: "",
      arraySabor: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorSabor: 0,
      errorMostrarMsjSabor: [],
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
    listarsabor(page, buscar, criterio) {
      let me = this;
      var url =
        "sabor/listar?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arraySabor = respuesta.sabores.data;
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
      me.listarsabor(page, buscar, criterio);
    },
    registrarsabor() {
      if (this.validarsabor()) {
        return;
      }

      let me = this;

      axios
        .post("sabor/registrar", {
          nombre: this.nombre,
          descripcion: this.descripcion
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarsabor(1, "", "nombre");
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'El sabor ha sido Creado con Exito'
          })
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizarsabor() {
      if (this.validarsabor()) {
        return;
      }

      let me = this;

      axios
        .put("sabor/actualizar", {
          nombre: this.nombre,
          descripcion: this.descripcion,
          id: this.sabor_id
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarsabor(1, "", "nombre");
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'El sabor ha sido Actualizado con Exito'
          })
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    desactivarsabor(id) {
      Swal.fire({
        title: 'Estas Seguro?',
        text: "Desactivar este Sabor!",
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
            .put("sabor/desactivar", {
              id: id
            })
            .then(function(response) {
              me.listarsabor(1, "", "nombre");
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
    activarsabor(id) {
      Swal.fire({
        title: 'Estas Seguro?',
        text: "Activar este Sabor!",
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
            .put("sabor/activar", {
              id: id
            })
            .then(function(response) {
              me.listarsabor(1, "", "nombre");
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
    validarsabor() {
      this.errorSabor = 0;
      this.errorMostrarMsjSabor = [];

      if (!this.nombre)
        this.errorMostrarMsjSabor.push(
          "El nombre del no puede estar vacío."
        );

      if (this.errorMostrarMsjSabor.length) this.errorSabor = 1;

      return this.errorSabor;
    },
    cerrarModal() {      
      this.tituloModal = "";
      this.nombre = "";
      this.descripcion = "";
      this.errorSabor = 0;
      this.errorMostrarMsjSabor = [];
      $("#modalCU").modal("hide");
    },
    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "sabor": {
          switch (accion) {
            case "registrar": {              
              this.tituloModal = "Registrar Sabor";
              this.nombre = "";
              this.descripcion = "";
              this.tipoAccion = 1;
              $("#modalCU").modal("show");
              break;
            }
            case "actualizar": {
              //console.log(data);              
              this.tituloModal = "Actualizar Sabor";
              this.tipoAccion = 2;
              this.sabor_id = data["id"];
              this.nombre = data["nombre"];
              this.descripcion = data["descripcion"];
              $("#modalCU").modal("show");
              break;
            }
          }
        }
      }
    }
  },
  mounted() {
    this.listarsabor(1, this.buscar, this.criterio);
  }
};
</script>

