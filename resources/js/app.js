require('./bootstrap');

window.Vue = require('vue');


import Vue from 'vue'
import VueRouter from 'vue-router'

//PARA CONSULTAR EL ARRAY DE PERMISOS QUE SE CREO EN EL LAYOUT
import Permissions from './mixins/Permissions';
Vue.mixin(Permissions);

// Vue.directive('can', function (el, binding, vnode) {

//     if(Permissions.indexOf(binding.value) !== -1){
//        return vnode.elm.hidden = false;
//     }else{
//        return vnode.elm.hidden = true;
//     }
// })


Vue.component('select2', require('./components/select.vue').default);
Vue.component('pagination', require('./components/pagination.vue').default);
Vue.component('navigationmenu', require('./components/menu.vue').default);
Vue.component('itemmenu', require('./components/item-menu.vue').default);
Vue.component('switch-button', require('./components/switch-button.vue').default);

Vue.use(VueRouter)
import App from './views/App'
import Categoria from './views/Categoria'
import Producto from './views/Producto'
import Sabor from './views/Sabor'
import Tamano from './views/Tamano'
import Orden from './views/Orden'
import ventarango from './views/ventarango'
import Dashboard from './views/Dashboard'


import Nopage from './views/404'


const router=new VueRouter({
    //base: '/sisloli/public/',
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
            path: '/ventarango',
            name: 'ventarango',
            component: ventarango
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
        {
            path: '/admin',
            name: 'Dashboard',
            component: Dashboard
        }, 
    ]
});

const app = new Vue({
    el: '#app',
    components:{App},
    router
});

