<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>All Dispositivos</h4>
                            </div>
                            <div>
                                <input type="text" class="form-control mr-50" placeholder="Search" v-model="searchFillter" @keyup="searchDispositivo">
                            </div>
                            <div>
                                <router-link :to="{name:'dispositivoCreate'}" class="btn btn-success">Add Dispositivo</router-link>
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
                                    <th>Dispositivo Nombre</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="dispositivo in searchDispositivo" :key="dispositivo.id">
                                
                                    <td>{{dispositivo.nombre}}</td>
                                    <td>{{dispositivo.d_quantity}}</td>
                                    <td>
                                        <div v-if="dispositivo.d_quantity > 0" class="badge badge-success">Available</div>
                                        <div v-else="" class="badge badge-danger">Stock Out</div>
                                    </td>
                                
                                   
                                    <td>
                                        <router-link :to="{name:'dispositivoEdit',params:{id:dispositivo.id}}" class="btn-sm btn-info"><i class="fas fa-edit"></i></router-link>
                                    </td>
                                    
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
               
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "stock",
        data(){
            return {
                dispositivos:[],
                searchFillter:'',
            }
        },
        methods:{
            allDispositivo(){
                axios.get('api/dispositivos')
                    .then(res=>{
                        this.dispositivos = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
          
        },
        created() {
            this.allDispositivo();
        }
        ,
        mounted() {
            if(!User.loggedIn()){
                Toast.fire({
                    icon: 'warning',
                    title: 'Login First!',
                });
                this.$router.push({name:'login'})
            }

        },
        computed:{
            searchDispositivo(){
                return this.dispositivos.filter(dispositivo=>{
                    return dispositivo.nombre.match(this.searchFillter);
                })
            }
        }
    }
</script>

<style scoped>

</style>
