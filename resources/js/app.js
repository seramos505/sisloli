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

Vue.component('select2', require('./components/select.vue').default);
Vue.component('pagination', require('./components/pagination.vue').default);
Vue.component('navigationmenu', require('./components/menu.vue').default);
Vue.component('itemmenu', require('./components/item-menu.vue').default);

Vue.use(VueRouter)
import App from './components/App'
import Categoria from './components/CategoriaComponent'
import Producto from './components/ProductoComponent'
import Sabor from './components/SaborComponent'
import Tamano from './components/TamanoComponent'
import Orden from './components/OrdenComponent'

import Nopage from './components/404Component'


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
            path: '/sabor',
            name: 'sabor',
            component: Sabor
        }, 
        {
            path: '/tamano',
            name: 'tamano',
            component: Tamano
        }, 
        {
            path: '/producto',
            name: 'producto',
            component: Producto
        }, 
        {
            path: '/orden',
            name: 'orden',
            component: Orden
        },  
        {
            path: '/cliente',
            name: 'cliente',
            component: Nopage
        }, 
        {
            path: '/venta-diario',
            name: 'venta-diario',
            component: Nopage
        }, 
        {
            path: '/venta-mes',
            name: 'venta-mes',
            component: Nopage
        }, 
        {
            path: '/usuario',
            name: 'usuario',
            component: Nopage
        }, 
        {
            path: '/rol',
            name: 'rol',
            component: Nopage
        },
        {
            path: '/permiso',
            name: 'permiso',
            component: Nopage
        }, 
        {
            path: '/menu',
            name: 'menu',
            component: Nopage
        },    
        {
            path: '/ayuda',
            name: 'ayuda',
            component: Nopage
        },   
    ]
});

const app = new Vue({
    el: '#app',
    components:{App},
    router
});

