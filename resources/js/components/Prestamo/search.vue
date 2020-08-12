<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="prestamoDate">
                                    <label>Search For Date</label>
                                    <input type="date" class="form-control" v-model="form.date">
                                    <button class="btn btn-success mt-2" type="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="prestamoMonth">
                                    <label>Search For Month</label>
                                    <select v-model="form.month" class="form-control" id="">
                                        <option value="">--select month--</option>
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                    <button class="btn btn-success mt-2" type="submit">Submit</button>
                                </form>
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
                                    <th>Persona Nombre</th>
                                    <th>Total Quantity</th>                                    
                                    <th>Date</th>
                                    <th>Month</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="prestamo in prestamos" :key="prestamo.id">
                                    <td>{{prestamo.nombre}}</td>
                                    <td>{{prestamo.carrito_quantity}}</td>
                                    <td>{{prestamo.prestamo_date}}</td>
                                    <td>{{prestamo.prestamo_month}}</td>
                                    <td>
                                        <router-link :to="{name:'prestamoDetails',params:{id:prestamo.id}}" class="btn-sm btn-info">View</router-link>
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
        name: "prestamoDetails",
        data(){
            return {
                prestamos:[],
                details:[],
                form:{
                    date:'',
                    month:'',
                },
                searchFillter:'',
            }
        },
        methods:{
            prestamoMonth(){
                axios.post('api/prestamo-search-month',this.form)
                    .then(res=>{
                        this.prestamos = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
            prestamoDate(){
                axios.post('api/prestamo-search-date',this.form)
                    .then(res=>{
                        this.prestamos = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
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
