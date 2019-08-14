<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <div class="form-group">
                          <label for=""></label>
                          <select2 :options="arrayCliente" v-model="cliente">
                              
                          </select2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
        idcliente: 1,
        cliente: "",
        arrayCliente: []      
        };
    },
    methods: {
        selectCliente() {
            let me = this;
            var url = "cliente/selectCliente";
            axios
                .get(url)
                .then(function(response) {
                //var respuesta = response.data;
                me.arrayCliente = response.data;
                })
                .catch(function(error) {
                console.log(error);
                });
        },
    },
    mounted() {
        this.selectCliente();
    }
}
</script>

<style>

</style>


