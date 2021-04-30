<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>Add New Branch</h5>
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
                                <div class="col-sm-3 mt-2">Branch Name</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter Branch Name" v-model="branch_name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Address</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter Branch Address" v-model="address">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Phone</div>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" placeholder="Enter Phone" v-model="phone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2"></div>
                                <div class="col-sm-8">
                                <button type="submit" class="btn btn-success mt-3">Save Branch</button>
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
                branch_name: '',
                address: '',
                phone: '',
                company_id:'',
                errors: [],
            }
        },

        mounted(){
            this.getCompanyInfo();
        },

        methods: {
            // formSubmit Function
            formButton(e) {
                var self = this;

                // Check Validation
                if (self.branch_name && self.address && self.phone) {
                    let form = new FormData();
                    form.append('branch_name', self.branch_name)
                    form.append('address', self.address)
                    form.append('phone', self.phone)
                    form.append('company_id' , self.company_id)
                    axios.post(self.$apiURL + '/create_branch', form).then(function (res) {
                        if (res.data.status === 'Success') {
                            self.$swal({
                                title: "Success",
                                text: "Branch Successfully Created",
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
                if (!self.branch_name) {
                    self.errors.push("Branch Name Required");
                    // self.loading = false;
                    // self.submit_click = false;
                }
                if (!self.address) {
                    self.errors.push("Company Address Required");
                    // self.loading = false;
                    // self.submit_click = false;
                }
                if (!self.phone) {
                    self.errors.push("Company Phone is Required");
                    // self.loading = false;
                    // self.submit_click = false;
                }
                e.preventDefault();

            },

            getCompanyInfo(){
                axios.get(this.$apiURL+'/company_info/'+localStorage.getItem('id'))
                .then((res) => {
                    this.company_id = res.data.company_info.id;
                })
            }
        }
    }
</script>