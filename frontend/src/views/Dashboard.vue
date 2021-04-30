<template>
  <div>
    <CCard>
      <CCardBody>
        <div>
          <center>
            <h1>Welcome, {{ name }}</h1>
          </center>
        </div>
        <div v-if="role == 'company'">
          <CompanyDashboard />
        </div>

        <!-- <div v-else>
          <AdminDashboard />
        </div> -->

        <div v-if="role == 'employee'">
          <EmployeeDashboard />
        </div>

        <div v-if="role == 'manager'">
          <ManagerDashboard />
        </div>



      </CCardBody>
    </CCard>

  </div>
</template>

<script>
  // import axios from 'axios'
  import AdminDashboard from './AdminDashboard';
  import CompanyDashboard from './CompanyDashboard';
  import ManagerDashboard from './ManagerDashboard';
  import EmployeeDashboard from './EmployeeDashboard';

  export default {
    component: {
      AdminDashboard,
      CompanyDashboard,
      ManagerDashboard,
      EmployeeDashboard
    },
    data() {
      return {
        has_error: false,
        user: null,
        role: null,
        name: null
      }
    },

    mounted() {
      this.getUser();
    },

    methods: {
      getUser() {
        let u_role = localStorage.getItem('roles');
        this.role = u_role;
        this.name = localStorage.getItem('name'); 
        // axios.get(this.$apiURL + '/user/' + localStorage.getItem('id'))
        //   .then((res) => {
        //     this.user = res.data.user;
        //     console.log(this.user);
        //   })
      }
    }


  }
</script>