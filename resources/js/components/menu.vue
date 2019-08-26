<template>
<!-- Sidebar Menu -->
    <nav class="mt-2">

   
    
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
       
        
        <li v-for="item in arrayMenu" :key="item">
         
          <template v-if="item.submenu != []">{{item.nombre}}</template>
          
        </li>  


        <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Catalago
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <router-link class="nav-link" :to="{name: 'categoria'}"><i class="far fa-circle nav-icon"></i> Categoria</router-link>
                
              </li>
              <li class="nav-item">
                  <router-link  class="nav-link" :to="{name: 'producto'}"><i class="far fa-circle nav-icon"></i> Producto</router-link>
               
              </li>
              
            </ul>
          </li>


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
     return "<li>" + item.nombre + "</li>"
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

