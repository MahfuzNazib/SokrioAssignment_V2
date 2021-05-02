<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>All Employee List</h5>
            </CCardHeader>
            <CCardBody>
                <!-- Searching Start-->
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <input type="text" class="form-control mb-3" placeholder="Search by Name or Email..." v-model="search_string" v-on:keyup="employeeSearch()">
                </div>
                <!-- Searching End -->

                <div class="col-md-12">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <th>Employee Name</th>
                            <th>Email</th>
                            <th>Branch Name</th>
                            <th>Type</th>
                            <th>Action</th>
                        </thead>

                        <tbody v-if="is_searched == false">
                            <tr v-if="loading == true">
                                <td colspan="4">
                                    <center>
                                        <img :src="'../../../img/preview.gif'" height="auto" width="auto">
                                    </center>
                                </td>
                            </tr>
                            <!-- If No Record -->
                            <tr v-if="no_record == true">
                                <td colspan="4">
                                    <center>
                                        <span class="badge badge-danger">No Data...</span>
                                    </center>
                                </td>
                            </tr>
                            <tr v-else v-for="employee in employee_list" :key="employee.id">
                                <td>{{ employee.name }}</td>
                                <td>{{ employee.email }}</td>
                                <td>{{ employee.branch.branch_name }}</td>
                                <td>{{ employee.menuroles }}</td>
                                <td>
                                    <!-- <button class="btn btn-info btn-sm">View</button> &nbsp;&nbsp; -->
                                    <router-link :to="{name:'employee_edit', params:{id: employee.id}}">
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>

                        <!-- Search Result Start -->
                        <tbody v-if="is_searched == true">
                            <tr v-if="loading == true">
                                <td colspan="4">
                                    <center>
                                        <img :src="'../../../img/preview.gif'" height="auto" width="auto">
                                    </center>
                                </td>
                            </tr>

                            <!-- No Record Found Message Start-->
                            <tr v-if="no_record == true">
                                <td colspan="4">
                                    <center>
                                        <span class="badge badge-danger">Sorry, No Record Found.</span>
                                    </center>
                                </td>
                            </tr>
                            <!-- No Record Found Message End-->

                            <tr v-for="search in search_result" :key="search.id">
                                <td>{{ search.name }}</td>
                                <td>{{ search.email }}</td>
                                <td>{{ search.branch.branch_name }}</td>
                                <td>{{ search.menuroles }}</td>
                                <td>
                                    <router-link :to="{name:'employee_edit', params:{id: search.id}}">
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                        <!-- Search Result End -->
                    </table>
                </div>
            </CCardBody>
        </CCard>
    </div>
</template>


<script>
    import axios from 'axios';
    export default{
        data(){
            return{
                employee_list:'',
                loading:true,
                errors:[],
                no_record:false,
                search_string:'',
                is_searched:false,    
                search_result:'',
            }
        },

        mounted(){
            this.getAllEmployee();
        },

        methods:{
            getAllEmployee(){
                axios.get(this.$apiURL + '/employee_index/'+localStorage.getItem('id'))
                .then((res) => {
                    this.employee_list = res.data.employee_list;
                    console.log(this.employee_list);
                    if(this.employee_list.length == 0){
                        this.no_record = true;
                        this.loading = false;
                    }else{
                        this.no_record = false;
                        this.loading = false;   
                    }
                })
            },

            employeeSearch(){
                if(this.search_string.length > 3){
                    this.is_searched = true;
                    axios.get(this.$apiURL + '/employee_search/'+this.search_string)
                    .then((res) => {
                        this.search_result = res.data.search_result;
                        console.log(this.search_result);
                        if(this.search_result.length == 0){
                            this.no_record = true;
                        }else{
                            this.no_record = false;
                        }
                    }) 
                }else{
                    this.is_searched = false;
                    this.no_record = false;
                }
            }
        }
    }
</script>