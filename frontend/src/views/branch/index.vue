<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>All Branch List</h5>
            </CCardHeader>
            <CCardBody>
                <!-- Searching Start-->
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <input type="text" class="form-control mb-3" placeholder="Search by Name or Address..." v-model="search_string" v-on:keyup="branchSearch()">
                </div>
                <!-- Searching End -->

                <div class="col-md-12">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <th>Branch Name</th>
                            <th>Branch Addess</th>
                            <th>Phone No</th>
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
                            <tr v-else v-for="branch in branch_list" :key="branch.id">
                                <td>{{ branch.branch_name }}</td>
                                <td>{{ branch.address }}</td>
                                <td>{{ branch.phone }}</td>
                                <td>
                                    <!-- <button class="btn btn-info btn-sm">View</button> &nbsp;&nbsp; -->
                                    <router-link :to="{name:'branch_edit', params:{id: branch.id}}">
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
                                <td>{{ search.branch_name }}</td>
                                <td>{{ search.address }}</td>
                                <td>{{ search.phone }}</td>
                                <td>
                                    <!-- <button class="btn btn-info btn-sm">View</button> &nbsp;&nbsp; -->
                                    <router-link :to="{name:'branch_edit', params:{id: branch.id}}">
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
                branch_list:'',
                loading:true,
                errors:[],
                no_record:false,
                search_string:'',
                is_searched:false,    
                search_result:'',
            }
        },

        mounted(){
            this.getAllBranch();
        },

        methods:{
            getAllBranch(){
                axios.get(this.$apiURL + '/branch_index')
                .then((res) => {
                    this.branch_list = res.data.branch_list;
                    if(this.branch_list.length == 0){
                        this.no_record = true;
                        this.loading = false;
                    }else{
                        this.no_record = false;
                        this.loading = false;   
                    }
                })
            },

            branchSearch(){
                if(this.search_string.length > 3){
                    this.is_searched = true;
                    axios.get(this.$apiURL + '/branch_search/'+this.search_string)
                    .then((res) => {
                        this.search_result = res.data.search_result;
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