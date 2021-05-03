<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>Daily Check In. Current Time </h5>
            </CCardHeader>
            <CCardBody>
                <button class="btn btn-info" type="submit" @click="checkIn()">Check IN Now</button>
                <div v-if="loading == true">
                    <h6>Please wait...</h6>
                    <img :src="'../../../img/loading.gif'" height="auto" width="auto">
                </div>
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
                loading:false,
            }
        },

        mounted(){
            this.getInfo();
        },

        methods:{
            checkIn(){
                var self = this;
                self.loading = true;
                axios.post(this.$apiURL + '/check_in',{
                    company_id: this.company_id,
                    user_id: this.user_id,
                    branch_id: this.branch_id
                }).then(function (res) {
                        console.log(res.data.status);
                        if (res.data.status === 'Success') {
                            self.loading = false;
                            self.$swal({
                                title: "Success",
                                text: "Successfully Checked In",
                                type: "success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: "#00CCFF",
                                cancelButtonColor: "#00CCFF",
                                confirmButtonText: "OK",
                                closeOnCancel: true
                            }).then(() => {
                                self.$router.push({
                                    // name: 'AllEmployee'
                                });
                            });
                        }else if(res.data.status === 'early_check_in'){
                            self.loading = false;
                            self.$swal({
                                title: "Error",
                                text: "Can Not Check in before 07:45 am",
                                type: "error",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: "#00CCFF",
                                cancelButtonColor: "#00CCFF",
                                confirmButtonText: "OK",
                                closeOnCancel: true
                            }).then(() => {
                                self.$router.push({
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