<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Add Persona</h4>
                            </div>
                            <div>
                                <router-link :to="{name:'personaIndex'}" class="btn btn-success">All Personas</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="personaAdd">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nombre<span class="text-danger">*</span></label>
                                        <input v-model="form.nombre" type="text" class="form-control" placeholder="Nombre Completo">
                                        <small class="text-danger" v-if="errors.nombre">{{errors.nombre[0]}}</small>
                                    </div>
                                </div>                            

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de persona <span class="text-danger">*</span></label>
                                        <input v-model="form.tipo_persona" type="text" class="form-control" placeholder="Tipo persona">
                                        <small class="text-danger" v-if="errors.tipo_persona">{{errors.tipo_persona[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-info"><i class="fas fa-plus"></i> Add Persona</button>
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
        name: "create",
        data(){
            return {
                form:{
                    tipo_persona:'',
                    nombre:''
                },
                errors:{},
            }
        },
        methods:{
            personaAdd(){
                axios.post('api/personas',this.form)
                .then(res=>{
                    Notification.success();
                    this.$router.push({name:'personaIndex'}) //router-link
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
