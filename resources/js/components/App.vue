<template>
  <div>

  <p>
    <router-link :to="{name: 'categoria'}">Categoria</router-link>
    <router-link :to="{name: 'producto'}">Producto</router-link>
  </p>
  <router-view></router-view>
  
      
  </div>
</template>

<script>
export default {};
</script>
