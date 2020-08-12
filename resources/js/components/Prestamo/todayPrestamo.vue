<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>Today Prestamos</h4>
                            </div>
                            <div>
                                <input type="text" class="form-control mr-50" placeholder="Search" v-model="searchPersonaNombre" @keyup="prestamoSerch">
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
                                    <th>Persona Nombre</th>
                                    <th>Total Quantity</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="prestamo in prestamoSerch" :key="prestamo.id">
                                    <td>{{prestamo.nombre}}</td>
                                    <td>{{prestamo.carrito_quantity}}</td>
                                    <td>
                                        <router-link :to="{name:'prestamoDetails',params:{id:prestamo.id}}" class="btn-sm btn-info">Prestamo Details</router-link>
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
        name: "todayPrestamo",
        data(){
            return {
                prestamos:[],
                searchPersonaNombre:'',
            }
        },
        methods:{
            todayPrestamos(){
                axios.get('api/today-prestamos')
                    .then(res=>{
                        this.prestamos = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
        },
        created() {
            this.todayPrestamos();
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
            prestamoSerch(){
                return this.prestamos.filter(prestamo=>{
                    return prestamo.nombre.match(this.searchPersonaNombre);
                })
            }
        }
    }
</script>

<style scoped>

</style>
