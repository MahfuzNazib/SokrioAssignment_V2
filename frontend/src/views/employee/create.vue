<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>Add New Employee</h5>
            </CCardHeader>
            <CCardBody>
                <CForm @submit.prevent="register" method="POST">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row" v-bind:class="{ 'has-error': errors.name }">
                                <div class="col-sm-3 mt-2">Employee Name</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter Employee Name"
                                        v-model="name">
                                    <span class="text-danger" v-if="errors.name">{{ errors.name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row" v-bind:class="{ 'has-error': errors.email }">
                                <div class="col-sm-3 mt-2">Email</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter Email Address"
                                        v-model="email">
                                    <span class="text-danger" v-if="errors.email">{{ errors.email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row" v-bind:class="{ 'has-error': errors.password }">
                                <div class="col-sm-3 mt-2">Set Primary Password</div>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" placeholder="Primary Password"
                                        v-model="password">
                                    <span class="text-danger" v-if="errors.password">{{ errors.password }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row" v-bind:class="{ 'has-error': errors.menuroles }">
                                <div class="col-sm-3 mt-2">Type</div>
                                <div class="col-sm-8">
                                    <select class="form-control" v-model="menuroles"
                                        @change="select_employee_type($event)">
                                        <option>manager</option>
                                        <option>employee</option>
                                    </select>
                                    <span class="text-danger" v-if="errors.menuroles">{{ errors.menuroles }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row" v-bind:class="{ 'has-error': errors.branch_id }">
                                <div class="col-sm-3 mt-2">Branch Name</div>
                                <div class="col-sm-8">
                                    <select class="form-control" v-model="branch_id"
                                        @change="select_branch_name($event)">
                                        <option selected disabled>Please Select Branch Name</option>
                                        <option v-for="branch in branches" :key="branch.id" v-bind:value="branch.id">
                                            {{ branch.branch_name }}</option>
                                    </select>
                                    <span class="text-danger" v-if="errors.branch_id">{{ errors.branch_id }}</span>
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
                password: '',
                password_confirmation: '',
                menuroles: '',
                branch_id: '',
                branches: null,
                company_id: '',
                errors: {},
            }
        },

        mounted() {
            this.getAllBranch();
        },

        methods: {
            register() {
                var self = this;
                axios.post(this.$apiAdress + '/api/employee_register', {
                        name: self.name,
                        email: self.email,
                        password: self.password,
                        menuroles: self.menuroles,
                        branch_id: self.branch_id,
                        company_id: self.company_id
                    }).then(function (response) {
                        if (response.data.status === 'Success') {
                            self.$swal({
                                title: "Success",
                                text: "Employee Successfully Created",
                                type: "success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: "#00CCFF",
                                cancelButtonColor: "#00CCFF",
                                confirmButtonText: "OK",
                                closeOnCancel: true
                            }).then(() => {
                                self.$router.push({
                                    name: 'AllEmployee'
                                });
                            });
                        }
                        // If Validation error
                        if (response.data.status === 'error') {
                            self.errors = response.data.errors;
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },

            select_employee_type(e) {
                var app = this;
                app.menuroles = e.target.value;
                console.log(app.menuroles);
            },

            getAllBranch() {
                axios.get(this.$apiURL + '/get_branches/' + localStorage.getItem('id'))
                    .then((res) => {
                        this.branches = res.data.branches;
                        this.company_id = res.data.company_id.id;
                    })
            },
        }
    }
</script>