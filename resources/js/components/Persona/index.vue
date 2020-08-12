<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>All personas</h4>
                            </div>
                            <div>
                                <input type="text" class="form-control mr-50" placeholder="Search" v-model="searchPersonaData" @keyup="searchPersona">
                            </div>
                            <div>
                                <router-link :to="{name:'personaCreate'}" class="btn btn-success">Add personas</router-link>
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
                                    <th>#</th>
                                    <th>Tipo de personas</th>
                                    <th>Nombre</th>
                                </tr>
                                <tr v-for="persona in searchPersona" :key="persona.id">
                                    <td>{{persona.id}}</td> 
                                    <td>{{persona.tipo_persona}}</td>                                   
                                    <td>{{persona.nombre}}</td>
                                                                        
                                    <td>
                                        <router-link :to="{name:'personaEdit',params:{id:persona.id}}" class="btn-sm btn-info"><i class="fas fa-edit"></i></router-link>
                                        <a @click="personasDel(persona.id)" class="btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
                personas:[],
                searchPersonaData:'',
            }
        },
        methods:{
            allpersona(){
                axios.get('api/personas')
                    .then(res=>{
                        this.personas = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
            personasDel(id){
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
                        axios.delete('api/personas/'+id)
                            .then(()=>{
                                Notification.error();
                                this.personas = this.personas.filter(persona=>{
                                    return persona.id != id; //imprimir en consola
                                })
                            }).catch(()=>{
                            this.$router.push({name:'personaIndex'})
                        })
                        }

                })
            }
        },
        created() {
            this.allpersona();
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
            searchPersona(){
                return this.personas.filter(persona=>{
                    return persona.nombre.match(this.searchPersonaData);
                })
            }
        }
    }
</script>

<style scoped>

</style>
