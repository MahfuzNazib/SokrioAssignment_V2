<template>
    <div>
       <CCard>
            <CCardHeader>
                <h5>Edit Branch</h5>
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
                    <div class="col-md-6">
                    <!-- Show Error Messages -->
                    <p v-if="errors.length">
                        <b class="text-danger text-bold">Please correct the following error(s):</b>
                        <ul>
                            <li class="text-danger" v-for="error in errors" :key="error.id">{{ error }}</li>
                        </ul>
                    </p>
                    <!-- End Error Messages -->

                    <form method="post">
                        <label>Branch Name</label>
                        <input type="text" class="form-control" v-model="branch_name">

                        <label>Address</label>
                        <input type="text" class="form-control" v-model="address">

                        <label>Phone No</label>
                        <input type="number" class="form-control" v-model="phone">
                        <br>
                    </form>

                    <button type="submit" @click="updateBranch()" class="btn btn-info mr-3">Save</button>
                    <button type="submit" @click="deleteBranch()" class="btn btn-danger">Delete</button>

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
                branch_id: '',
                branch_name: '',
                address: '',
                phone: '',
                errors: [],
                loading: false,
                submit_click: false,
            }
        },

        mounted() {
            let id = this.$route.params.id;
            this.branch_id = id;
            axios.get(this.$apiURL + '/branch_edit/' + this.branch_id)
                .then((res) => {
                    this.branch_name = res.data.branch_info.branch_name;
                    this.address = res.data.branch_info.address;
                    this.phone = res.data.branch_info.phone;
                })
        },

        methods: {
            updateBranch(e) {
                let app = this;
                this.loading = true;
                this.submit_click = true;

                // Check Validation
                if (this.branch_name && this.address && this.phone) {
                    let form = new FormData();
                    form.append('branch_name', this.branch_name)
                    form.append('address', this.address)
                    form.append('phone', this.phone)
                    form.append('company_id', 1)
                    axios.post(this.$apiURL + '/branch_edit/' + this.branch_id, form)
                        .then(function (res) {
                            if (res.data.status == 'Success') {
                                app.$swal({
                                    title: "Success",
                                    text: "Branch Successfully Updated",
                                    type: "success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: "#00CCFF",
                                    cancelButtonColor: "#00CCFF",
                                    confirmButtonText: "OK",
                                    closeOnCancel: true
                                }).then(() => {
                                    app.$router.push({
                                        path: 'branch_index'
                                    });
                                });
                            } else {
                                this.errors = res.data.errors;
                                this.loading = false;
                                this.submit_click = false;
                            }
                        })
                }

                this.errors = [];
                if (!this.branch_name) {
                    this.errors.push("Branch Name Required");
                    this.loading = false;
                    this.submit_click = false;
                }
                if (!this.address) {
                    this.errors.push("Company Address Required");
                    this.loading = false;
                    this.submit_click = false;
                }
                if (!this.phone) {
                    this.errors.push("Company Phone is Required");
                    this.loading = false;
                    this.submit_click = false;
                }
                e.preventDefault();
            },

            // Soft Delete Branch
            deleteBranch() {
                let app = this;
                app.$swal({
                    title: "Confirmation Message",
                    text: "Are you sure to Delete this branch? ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#d20001",
                    cancelButtonColor: "#00CCFF",
                    confirmButtonText: "Yes, Delete!",
                    closeOnCancel: true
                }).then((result) => {
                    if (result.value) {
                        axios.post(this.$apiURL + '/branch_delete/' + app.branch_id)
                            .then(function () {
                                app.$swal({
                                    title: 'Success',
                                    text: 'Branch Successfully Deleted',
                                    type: 'success',
                                    showConfirmButton: true,
                                }).then(() => {
                                    app.$router.push({
                                        path: 'branch_index'
                                    });
                                });
                            })
                            .catch(function () {
                                app.$swal({
                                    title: 'Error',
                                    text: 'Could not load Branch',
                                    type: 'warning',
                                    confirmButtonColor: "#d20001",
                                })
                            });
                    }
                });
            }
        }
    }
</script>