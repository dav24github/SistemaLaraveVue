<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-group">
                                    <a class="list-group-item list-group-item-action active">
                                        Persona Info
                                    </a>
                                    <a  class="list-group-item list-group-item-action"><strong>Tipo de persona:</strong> {{prestamos.tipo_persona}}</a>
                                    <a  class="list-group-item list-group-item-action"><strong>Nombre:</strong> {{prestamos.nombre}}</a>   
                                    <a  class="list-group-item list-group-item-action"><strong>Date:</strong> {{prestamos.prestamo_date}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-group">
                                    <a class="list-group-item list-group-item-action active">
                                        Prestamo Info
                                    </a>
                                    <a  class="list-group-item list-group-item-action"><strong>Dispositivo Quantity:</strong> {{prestamos.carrito_quantity}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>Dispositivo Details</h4>
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
                                    <th>Dispositivo Name</th>
                                    <th>Quantity</th>
                                </tr>
                                <tr v-for="dispositivo in details" :key="dispositivo.id">                                   
                                    <td>{{dispositivo.nombre}}</td>
                                    <td>{{dispositivo.dispositivo_quantity}}</td>
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
        name: "prestamoDetails",
        data(){
            return {
                prestamos:[],
                details:[],
                searchFillter:'',
            }
        },
        methods:{
            prestamoInfo(){
                let id = this.$route.params.id;
                axios.get('api/prestamo-info/'+id)
                    .then(res=>{
                        this.prestamos = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
            prestamoDetails(){
                let id = this.$route.params.id;
                axios.get('api/prestamo-details/'+id)
                    .then(res=>{
                        this.details = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
        },
        created() {
            this.prestamoInfo();
            this.prestamoDetails();
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
    }
</script>

<style scoped>

</style>
