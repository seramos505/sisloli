require('./bootstrap');

window.Vue = require('vue');


import Vue from 'vue'
import VueRouter from 'vue-router'

//PARA CONSULTAR EL ARRAY DE PERMISOS QUE SE CREO EN EL LAYOUT
Vue.directive('can', function (el, binding, vnode) {

    if(Permissions.indexOf(binding.value) !== -1){
       return vnode.elm.hidden = false;
    }else{
       return vnode.elm.hidden = true;
    }
})

Vue.component('pagination', require('./components/pagination.vue').default);
Vue.component('navigationmenu', require('./components/menu.vue').default);

Vue.use(VueRouter)
import App from './components/App'
import Categoria from './components/CategoriaComponent'
import Producto from './components/ProductoComponent'


const router=new VueRouter({
    mode: 'history',
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
    routes: [
        {
            path: '/categoria',
            name: 'categoria',
            component: Categoria
        },
        {
            path: '/producto',
            name: 'producto',
            component: Producto
        },        
    ]
});

const app = new Vue({
    el: '#app',
    components:{App},
    router
});

