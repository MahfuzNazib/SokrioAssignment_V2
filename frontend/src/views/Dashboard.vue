<template>
  <div>
    <CCard>
      <CCardBody>
        <div v-if="role == 'company'">
          <h1>This is company dashboard</h1>
        </div>
        <div v-else>
        This is Super Admin Dashboard
          
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
        has_error:false,
        user:null,
        role:null
      }
    },

    mounted(){
      this.getUser();
    },

    methods:{
      getUser(){
        let u_role = localStorage.getItem('roles');
        this.role = u_role;
        axios.get(this.$apiURL + '/user/'+localStorage.getItem('id'))
        .then((res) => {
          this.user = res.data.user;
          console.log(this.user);
        })
      }
    }


  }
</script>