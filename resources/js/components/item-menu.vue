<template>
    <li class="nav-item has-treeview">        
        <template v-if="item.submenu.length">            
            <a href="javascript:;" class="nav-link" :class="{'active': isExpanded }">
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
                <span  v-on:click="expandmenu">
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
        expandmenu(){
            this.isExpanded = !this.isExpanded;
        }
    }
}
</script>

