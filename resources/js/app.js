/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//PARA CONSULTAR EL ARRAY DE PERMISOS QUE SE CREO EN EL LAYOUT
Vue.directive('can', function (el, binding, vnode) {

    if(Permissions.indexOf(binding.value) !== -1){
       return vnode.elm.hidden = false;
    }else{
       return vnode.elm.hidden = true;
    }
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('categoria', require('./components/CategoriaComponent.vue').default);
Vue.component('sabor', require('./components/SaborComponent.vue').default);
Vue.component('tamano', require('./components/TamanoComponent.vue').default);
Vue.component('producto', require('./components/ProductoComponent.vue').default);
Vue.component('orden', require('./components/OrdenComponent.vue').default);





/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


