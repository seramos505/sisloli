<template>
    <li class="nav-item" :class="'id-'+[item.id]">        
        <template v-if="item.submenu.length">            
            <a href="javascript:;" class="nav-link" >
                <i class="nav-icon" :class="[item.icono]"></i>
                <p>
                    {{item.nombre}}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview ml-4">                   
                <template v-for="(item) in item.submenu">          
                    <itemmenu :item="item" :key="item.id"></itemmenu>             
                </template> 
            </ul>  
        </template> 
        <template v-else>             
            <router-link :to="{name: item.url}" class="nav-link">
                <span class="d-block" v-on:click="expandmenu(item.menu_id)">
                    <i class="nav-icon" :class="[item.icono]"></i>
                    <p>{{item.nombre}}</p>  
                </span>  
            </router-link>              
        </template>               
    </li>
</template>


<script>
export default {
    data() {
        return {
        isExpanded: false,
        }
    },
    props: ["item"],
    methods:{
        expandmenu(id){
            $('ul.nav-sidebar').children('li.nav-item').children('.nav-link').removeClass('active');
            $('ul.nav-sidebar').children('li.id-'+id).children('.nav-link').addClass('active');           
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                $('body').removeClass('sidebar-open');
                $('body').addClass('sidebar-collapse'); 
            } 
        }
    }
}
</script>

