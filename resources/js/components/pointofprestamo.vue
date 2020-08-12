<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <h4>All Cards</h4>
                                    <router-link :to="{name:'personaCreate'}" class="btn btn-info btn-sm">New Persona</router-link>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Qty</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="carrito in getAllCarritos" :key="carrito.id">
                                        <td>{{carrito.dispositivo_name}}</td>
                                        <td class="d-flex">
                                            <input type="text" readonly="" style="width:20px" :value="carrito.dispositivo_quantity">
                                            <button @click.prevent="carritoIncrement(carrito.id)" title="Increment" class="btn btn-sm btn-success">+</button>
                                            <button v-if="carrito.dispositivo_quantity >=2" @click.prevent="carritoDecrement(carrito.id)" title="Decrement" class="btn btn-sm btn-danger">-</button>
                                            <button v-else="" disabled @click.prevent="carritoDecrement(carrito.id)" title="Decrement" class="btn btn-sm btn-danger">-</button>
                                        </td>
                                        <td><button class="btn btn-sm btn-danger" @click.prevent="removeCarrito(carrito.id)">X</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <table class="table">
                                    <tbody>
                                    <tr style="line-height:1.5">
                                        <td>Total Quantity</td>
                                        <td class="text-right"><strong>{{this.totaltQuantity}}</strong></td>
                                    </tr>                                    
                                    </tbody>
                                </table>
                                <hr>
                                <h5><strong>Persona</strong></h5>
                                <form @submit.prevent="prestamoDone">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <select class="form-control" v-model="persona_id">
                                                    <option :value="persona.id" v-for="persona in allPersonas">{{persona.nombre}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h4>All Dispositivos</h4>
                                </div>
                            </div>
                                <div class="card-body">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">All Dispositivo</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <input type="text" v-model="searchFillterAllDispositivo"  class="form-control" placeholder="search"><br>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-4" v-for="dispositivo in searchAllDispositivo" :key="dispositivo.id">
                                                    <button class="btn bt-sm" v-if="dispositivo.d_quantity < 1" disabled @click.prevent="addToCarrito(dispositivo.id)">
                                                        <div class="card" style="width: 9rem; height: 180px;">                                                           
                                                            <div class="card-body">
                                                                <small class="card-title">{{dispositivo.nombre}}</small>
                                                                <span class="badge badge-success" v-if="dispositivo.d_quantity >=1"> Availble({{dispositivo.d_quantity}}) </span>
                                                                <span class="badge badge-danger" v-else="">Stock Out </span>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <button class="btn bt-sm" v-else="" @click.prevent="addToCarrito(dispositivo.id)">
                                                        <div class="card" style="width: 9rem; height: 180px;">
                                                            <div class="card-body">
                                                                <small class="card-title">{{dispositivo.nombre}}</small>
                                                                <span class="badge badge-success" v-if="dispositivo.d_quantity >=1"> Availble({{dispositivo.d_quantity}}) </span>
                                                                <span class="badge badge-danger" v-else="">Stock Out</span>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "pointofsell",
        data(){
            return {
                allDispositivos:[],
                searchFillterAllDispositivo:'',
                allPersonas:[],
                persona_id:'',
                getAllCarritos:[],
                totaltQuantity:'',
            }
        },
        methods:{
            allDispositivo(){
                axios.get('api/dispositivos')
                    .then(res=>{
                        this.allDispositivos = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
            allPersona(id){
                axios.get('api/personas')
                    .then(res=>{
                        this.allPersonas = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },

            //carrito method start
            addToCarrito(id){
                axios.get('api/add-to-carrito/dispositivo/'+id)
                    .then(res=>{
                        if(res.data.error){
                            Toast.fire({
                                icon: 'error',
                                title: 'Dispositivo Limited. Stock out!',
                            });
                        }else{
                            Reload.$emit('afterChange');
                            Notification.addTocarrito();
                        }
                    }).catch(error=>{console.log(error.response.data)});
            },
           allCarritos(){
                axios.get('api/dispositivo/carritos')
                    .then(res=>{
                        this.getAllCarritos = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
            removeCarrito(id){
                axios.get('api/carrito-remove/'+id)
                    .then(res=>{
                        Reload.$emit('afterChange');
                        Notification.carritoRemove();
                    }).catch(error=>{console.log(error.response.data)});
            },
            carritoIncrement(id){
                axios.get('api/carrito-increment/'+id)
                    .then(res=>{
                        if(res.data.error){
                            Toast.fire({
                                icon: 'error',
                                title: 'Dispositivo Limited. Stock out!',
                            });
                        }else{
                            Reload.$emit('afterChange');
                            Notification.increment();
                        }

                    }).catch(error=>{console.log(error.response.data)});
            },
            carritoDecrement(id){
                axios.get('api/carrito-decrement/'+id)
                    .then(res=>{
                        Reload.$emit('afterChange');
                        Notification.decrement();
                    }).catch(error=>{console.log(error.response.data)});
            },
            totalCarritoQuantity(){
                axios.get('api/carrito-quantity')
                    .then(res=>{
                        this.totaltQuantity = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },            
            prestamoDone(){
                let data={
                    persona_id:this.persona_id,
                    carrito_quantity:this.totaltQuantity
                }
                axios.post('api/prestamo-done',data)
                    .then(res=>{
                        Notification.success();
                        this.$router.push({name:'home'});
                    }).catch(error=>{console.log(error.response.data)});
            },
            // carrito method end

        },
        created() {
            this.allDispositivo();
            this.allPersona();
            this.allCarritos();
            this.totalCarritoQuantity();
            Reload.$on('afterChange',()=>{
                this.allCarritos();
                this.totalCarritoQuantity();
            })
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
        computed:{
            searchAllDispositivo(){
                return this.allDispositivos.filter(dispositivo=>{
                    return dispositivo.nombre.match(this.searchFillterAllDispositivo);
                })
            },
        }
    }
</script>

<style scoped>
 .table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th {
     padding: 0 10px;
     height: 35px !important;
     vertical-align: middle;
 }
 .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
     position: relative;
     width: 100%;
     padding-right: 0px!important;
     padding-left: 4px!important;
 }
</style>
