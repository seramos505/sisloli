<template>
       <nav>
            <ul class="pagination">
              <li class="page-item" :class="[pagination.current_page == 1 ? 'disabled' : '']">
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
              <li class="page-item" :class="[pagination.current_page == pagination.last_page ? 'disabled' : '']">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
                >Sig</a>
              </li>
            </ul>
             {{pagination}}
          </nav>
     

</template>

<script>
export default {
    data() {
    return {    
      offset: 3
    };
  },
  props:["pagination",'cambiarPagina','buscar','criterio'],
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
  },
//   methods:{
//     ChangePage(page, buscar, criterio) {
//       let me = this;
//       //Actualiza la página actual
//       //me.pagination.current_page = page;
//       //Envia la petición para visualizar la data de esa página
//       me.cambiarPagina(page, buscar, criterio);
//     },
 // }
  
};
</script>

<style>
</style>