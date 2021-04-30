<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>Add Designation</h5>
            </CCardHeader>
            <CCardBody>
                <!-- Show Error Messages -->
                    <!-- <p v-if="errors.length">
                        <b class="text-danger text-bold">Please correct the following error(s):</b>
                        <ul>
                            <li class="text-danger" v-for="error in errors" :key="error.id">{{ error }}</li>
                        </ul>
                    </p> -->
                    <!-- End Error Messages -->
                <CForm @submit.prevent="formButton" method="POST">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Title</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter Designation Title" v-model="title">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Branch Name</div>
                                <div class="col-sm-8">
                                    <select class="form-control" v-model="branch_id">
                                        <option selected disabled>Please Select Branch Name</option>
                                        <option v-for="branch in branches" :key="branch.id">{{ branch.branch_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2"></div>
                                <div class="col-sm-8">
                                <button type="submit" class="btn btn-success mt-3">Save Designation</button>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </CForm>
            </CCardBody>
        </CCard>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data(){
            return{
                branches:null,
                title:'',
                branch_id:'',
            }
        },

        mounted(){
            this.getAllBranch();
        },

        methods:{
            getAllBranch(){
                axios.get(this.$apiURL+'/get_branches/'+localStorage.getItem('id'))
                .then((res) => {
                    this.branches = res.data.branches;
                })
            }
        }
    }
</script>
