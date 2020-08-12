<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Update Dispositivo</h4>
                            </div>
                            <div>
                                <router-link :to="{name:'dispositivoIndex'}" class="btn btn-success">All Dispositivos</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="dispositivoEdit" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dispositivo Nombre <span class="text-danger">*</span></label>
                                        <input v-model="form.nombre" type="text" class="form-control" placeholder="Dispositivo Nombre">
                                        <small class="text-danger" v-if="errors.nombre">{{errors.nombre[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dispositivo Quantity <span class="text-danger">*</span></label>
                                        <input v-model="form.d_quantity" type="number" class="form-control" placeholder="Dispositivo Quantity">
                                        <small class="text-danger" v-if="errors.d_quantity">{{errors.d_quantity[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-info"><i class="fas fa-plus"></i> Update Dispositivo</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "edit",
        data(){
            return {
                form:{
                    nombre:'',
                    d_quantity:'',
                },
                errors:{},
            }
        },
        created() {
            let id = this.$route.params.id;

            axios.get('api/dispositivos/'+id)
            .then(res=>{
                this.form = res.data;
            })
                .catch(error=>{})
        },
        methods:{
            dispositivoEdit(){
                let id = this.$route.params.id;
                axios.patch('api/dispositivos/'+id,this.form)
                    .then(res=>{
                        Notification.success();
                        this.$router.push({name:'dispositivoIndex'})
                    })
                    .catch(error=>{
                        this.errors = error.response.data.errors;
                        console.log(error.response.data.errors)
                    })
            },           
        },
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
