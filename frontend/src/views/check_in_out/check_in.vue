<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>Daily Check In. Current Time </h5>
            </CCardHeader>
            <CCardBody>
                <button class="btn btn-info" type="submit" @click="checkIn()">Check IN Now</button>
            </CCardBody>
        </CCard>
    </div>
</template>

<script>
import axios from 'axios'
    export default {
        data() {
            return {
                company_id:'',
                user_id:'',
                branch_id:'',
            }
        },

        mounted(){
            this.getInfo();
        },

        methods:{
            checkIn(){
                axios.post(this.$apiURL + '/check_in').then(function (res) {
                        if (res.data.status === 'Success') {
                            this.$swal({
                                title: "Success",
                                text: "Successfully Checked IN",
                                type: "success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: "#00CCFF",
                                cancelButtonColor: "#00CCFF",
                                confirmButtonText: "OK",
                                closeOnCancel: true
                            }).then(() => {
                                this.$router.push({
                                    // path: 'branch_index'
                                });
                            });
                        }else{
                            this.errors = res.data.errors;
                        }
                    })
            },

            getInfo(){
                axios.get(this.$apiURL+ '/get_info/'+localStorage.getItem('id'))
                .then((res) => {
                    this.company_id = res.data.getInfo.company_id;
                    this.user_id = localStorage.getItem('id');
                    this.branch_id = res.data.getInfo.branch_id;
                })
            }
        }
    }
</script>