<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>Add New Employee</h5>
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
                <CForm @submit.prevent="register" method="POST">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Employee Name</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter Employee Name"
                                        v-model="name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Email</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter Email Address"
                                        v-model="email">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Set Primary Password</div>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" placeholder="Primary Password"
                                        v-model="password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Type</div>
                                <div class="col-sm-8">
                                    <select class="form-control" v-model="menuroles"
                                        @change="select_employee_type($event)">
                                        <option>manager</option>
                                        <option>employee</option>
                                    </select>
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
                                    <button type="submit" class="btn btn-success mt-3">Save</button>
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
    import axios from 'axios'
    export default {
        data() {
            return {
                name: '',
                email: '',
                address: '',
                phone: '',
                password: '',
                password_confirmation: '',
                menuroles: '',
                branch_id:'',
                branches:null
            }
        },

        mounted(){
            this.getAllBranch();
        },
        
        methods: {
            register() {
                var self = this;
                axios.post(this.$apiAdress + '/api/employee_register', {
                        name: self.name,
                        email: self.email,
                        address: self.address,
                        phone: self.phone,
                        password: self.password,
                        password_confirmation: self.password_confirmation,
                        menuroles: self.menuroles
                    }).then(function (response) {
                        self.name = '';
                        self.email = '';
                        self.address = '',
                            self.phone = '',
                            self.password = '';
                        self.password_confirmation = '';
                        self.menuroles = '',
                        console.log(response);
                        // self.$router.push({
                        //   path: '/login'
                        // });
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },

            select_employee_type(e){
                var app = this;
                app.menuroles = e.target.value;
                console.log(app.menuroles);
            },

            getAllBranch(){
                axios.get(this.$apiURL+'/get_branches/'+localStorage.getItem('id'))
                .then((res) => {
                    this.branches = res.data.branches;
                })
            },
        }
    }
</script>