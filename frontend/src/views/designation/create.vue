<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>Add Designation</h5>
            </CCardHeader>
            <CCardBody>
                <!-- Show Error Messages -->
                    <p v-if="errors.length">
                        <b class="text-danger text-bold">Please correct the following error(s):</b>
                        <ul>
                            <li class="text-danger" v-for="error in errors" :key="error.id">{{ error }}</li>
                        </ul>
                    </p>
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
                                    <select class="form-control" v-model="branch_id" @change="select_branch_name($event)">
                                        <option selected disabled>Please Select Branch Name</option>
                                        <option v-for="branch in branches" :key="branch.id" v-bind:value="branch.id">{{ branch.branch_name }}</option>
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
                errors:[],
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
            },

            select_branch_name(e){
                var app = this;
                app.branch_id = e.target.value;
                console.log(app.branch_id);
            },

            formButton(e){
                var self = this;

                if (self.title && self.branch_id) {
                    let form = new FormData();
                    form.append('title', self.title)
                    form.append('branch_id', self.branch_id)
                    axios.post(self.$apiURL + '/create_designation', form).then(function (res) {
                        if (res.data.status === 'Success') {
                            self.$swal({
                                title: "Success",
                                text: "Designation Successfully Created",
                                type: "success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: "#00CCFF",
                                cancelButtonColor: "#00CCFF",
                                confirmButtonText: "OK",
                                closeOnCancel: true
                            }).then(() => {
                                self.$router.push({
                                    path: 'branch_index'
                                });
                            });
                        }else{
                            self.errors = res.data.errors;
                        }
                    })
                }

                self.errors = [];
                if (!self.title) {
                    self.errors.push("Designation Title Required");
                }
                if (!self.branch_id) {
                    self.errors.push("Branch Name Required");
                }
                e.preventDefault();
            }
        }
    }
</script>
