<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>All Prestamos</h4>
                            </div>
                            <div>
                                <input type="text" class="form-control mr-50" placeholder="Search" v-model="searchPersonaNombre" @keyup="prestamoSearch">
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
                                    <th>Persona Nombre</th>
                                    <th>Total Quantity</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="prestamo in prestamoSearch" :key="prestamo.id">
                                    <td>{{prestamo.nombre}}</td>
                                    <td>{{prestamo.carrito_quantity}}</td>
                                    <td>{{prestamo.prestamo_date}}</td>
                                    <td>
                                        <router-link :to="{name:'prestamoDetails',params:{id:prestamo.id}}" class="btn-sm btn-info">Prestamo Details</router-link>
                                        <a @click="prestamoDel(prestamo.id)" class="btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
        name: "prestamos",
        data(){
            return {
                prestamos:[],
                searchPersonaNombre:'',
            }
        },
        methods:{
            allPrestamos(){
                axios.get('api/prestamos')
                    .then(res=>{
                        this.prestamos = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
            prestamoDel(id){
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
                        axios.delete('api/prestamo-delete/'+id)
                            .then(()=>{
                                Reload.$emit('afterChange');
                                Notification.error();
                            }).catch(()=>{
                            this.$router.push({name:'prestamos'})
                        })
                    }

                })
            }
        },
        created() {
            this.allPrestamos();
            Reload.$on('afterChange',()=>{
                this.allPrestamos();
            });
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
            prestamoSearch(){
                return this.prestamos.filter(prestamo=>{
                    return prestamo.nombre.match(this.searchPersonaNombre);
                })
            }
        }
    }
</script>

<style scoped>

</style>
