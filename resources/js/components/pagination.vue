<template>
  <nav v-if="pagination.last_page!=1">
    <ul class="pagination">
      <li class="page-item" :class="[pagination.current_page == 1 ? 'disabled' : '']">
        <a
          class="page-link"
          href="#"
          title="Primero"
          @click.prevent="cambiarPagina(1,buscar,criterio)"
        ><i class="fas fa-angle-double-left"></i></a>
      </li>
      <li class="page-item" :class="[pagination.current_page == 1 ? 'disabled' : '']">
        <a
          class="page-link"
          href="#"
          title="Anterior"
          @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)"
        ><i class="fas fa-angle-left"></i></a>
      </li>
      <li
        class="page-item"
        v-for="page in pagesNumber"
        :key="page"
        :class="[page == isActived ? 'active disabled' : '']"        
      >
        <a
          class="page-link"
          href="#"
          @click.prevent="cambiarPagina(page,buscar,criterio)"
          v-text="page"
        ></a>
      </li>
      <li
        class="page-item"
        :class="[pagination.current_page == pagination.last_page ? 'disabled' : '']"
      >
        <a
          class="page-link"
          href="#"
          title="Siguiente"
          @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
        ><i class="fas fa-angle-right"></i></a>
      </li>
      <li
        class="page-item"
        :class="[pagination.current_page == pagination.last_page ? 'disabled' : '']"
      >
        <a
          class="page-link"
          href="#"
          title="Ultimo"
          @click.prevent="cambiarPagina(pagination.last_page,buscar,criterio)"
        ><i class="fas fa-angle-double-right"></i></a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      offset: 3
    };
  },
  props: ["pagination", "cambiarPagina", "buscar", "criterio"],
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
    }
  }
};
</script>

<style>
</style>