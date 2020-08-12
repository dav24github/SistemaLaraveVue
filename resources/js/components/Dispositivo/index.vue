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
                                    <th colspan="2">Action</th>
                                </tr>
                                <tr v-for="dispositivo in searchDispositivo" :key="dispositivo.id">
                                    <td>{{dispositivo.nombre}}</td>
                                    <td>{{dispositivo.d_quantity}}</td>
                                    <td colspan="1">
                                        <router-link :to="{name:'dispositivoEdit',params:{id:dispositivo.id}}" class="btn-sm btn-info"><i class="fas fa-edit"></i></router-link>
                                    </td>
                                    <td colspan="1">
                                        <a @click="dispositivoDel(dispositivo.id)" class="btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "index",
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
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
            dispositivoDel(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('api/dispositivos/'+id)
                            .then(()=>{
                                Notification.error();
                                this.dispositivos = this.dispositivos.filter(dispositivo=>{
                                    return dispositivo.id != id;
                                })
                            }).catch(()=>{
                            this.$router.push({name:'dispositivoIndex'})
                        })
                        }

                })
            }
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
