<template>
<!-- Sidebar Menu -->
    <nav class="mt-2">

   
    
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
       
        
        <template v-for="(item) in arrayMenu">          
            <itemmenu :item="item" :key="item.id"></itemmenu>             
        </template> 

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
 
</template>

<script>
export default {
  data() {
    return {
      impuesto: "prueba",
      arrayMenu: [],
      valor: 0,
      
    };
  },
 
 methods:{
   MostrarMenu(item){     
     return  item.nombre 
   },
    listarMenu(front) {
      let me = this;
      var url ="menu/listar?page=1";
      axios
        .get(url)
        .then(function(response) {
          me.arrayMenu = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
  },
  mounted() {
    this.listarMenu(1);
  }
};
</script>

