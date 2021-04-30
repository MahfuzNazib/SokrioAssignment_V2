<template>
    <div>
        <CCard>
            <CCardHeader>
                <CIcon name="cil-drop" /> Investigation Code
            </CCardHeader>
            <CCardBody>
                <CForm @submit.prevent="saveinfo" method="POST">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Code</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter Code" v-model="code">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3 mt-2">Department</div>
                                <div class="col-sm-8">
                                    <select class="form-control" @change="SelectDepartment($event)">
                                        <option>Diagnosis</option>
                                        <option>Dental</option>
                                        <option>Dialysis</option>
                                        <option>Eye</option>
                                        <option>Optical</option>
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success">Save Informations</button>
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
                code: '',
                department: 'Diagnosis'
            }
        },
        methods: {
            SelectDepartment(e) {
                var app = this;
                app.department = e.target.value;
            },
            saveinfo() {
                var self = this;
                axios.post(this.$apiAdress + '/api/saveinfo', {
                    code: self.code,
                    department: self.department
                }).then(function (res) {
                    // self.code = '',
                    //     self.department = '',
                    //     self.$router.push({
                    //         path: '/dashboard'
                    //     })
                    if(res.data.status === 'Success'){
                        self.$swal({
                                title: "Success",
                                text: "Department Successfully Saved",
                                type: "success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: "#00CCFF",
                                cancelButtonColor: "#00CCFF",
                                confirmButtonText: "OK",
                                closeOnCancel: true
                            }).then(() => {
                                self.$router.push({
                                    name: 'Home'
                                });
                            });
                    }else{
                        console.log('Error Occured');
                    }
                })
            }
        }
    }
</script>