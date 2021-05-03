<template>
  <div class="d-flex align-items-center min-vh-100">
    <CContainer fluid>
      <CRow class="justify-content-center">
        <CCol md="6">
          <CCard class="mx-4 mb-0">
            <CCardBody class="p-4">
              <!-- Show Error Messages -->
              <p v-if="errors.length">
                <b class="text-danger text-bold">Please correct the following error(s):</b>
                <ul>
                  <li class="text-danger" v-for="error in errors" :key="error.id">{{ error }}</li>
                </ul>
              </p>
              <!-- End Error Messages -->
              <CForm @submit.prevent="register" method="POST">
                <h1>Register</h1>
                <p class="text-muted">Create Company Account</p>
                <CInput placeholder="Username" prependHtml="<i class='cui-user'></i>" autocomplete="username"
                  v-model="name">
                  <template #prepend-content>
                    <CIcon name="cil-user" /></template>
                </CInput>
                <CInput placeholder="Email" prepend="@" autocomplete="email" v-model="email" />
                <CInput placeholder="Address" prepend="@" autocomplete="address" v-model="address" />
                <CInput placeholder="phone" prepend="@" autocomplete="phone" v-model="phone" />

                <CInput placeholder="Password" type="password" prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password" v-model="password">
                  <template #prepend-content>
                    <CIcon name="cil-lock-locked" /></template>
                </CInput>
                <CInput placeholder="Repeat password" type="password" prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password" class="mb-4" v-model="password_confirmation">
                  <template #prepend-content>
                    <CIcon name="cil-lock-locked" /></template>
                </CInput>
                <CButton type="submit" color="success" block>Create Account</CButton>
                <center>
                  <router-link :to="{path:'/login'}">Login</router-link>
                </center>
              </CForm>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
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
        errors: [],
      }
    },
    methods: {
      register(e) {
        var self = this;
        if (self.name && self.email && self.password) {
          axios.post(this.$apiAdress + '/api/register', {
              name: self.name,
              email: self.email,
              address: self.address,
              phone: self.phone,
              password: self.password,
              password_confirmation: self.password_confirmation
            }).then(function (response) {
              // If Validation error
              if (response.data.status === 'error') {
                self.errors = response.data.errors;
              }

              self.name = '';
              self.email = '';
              self.address = '',
                self.phone = '',
                self.password = '';
              self.password_confirmation = '';
              console.log(response);
              self.$router.push({
                path: '/login'
              });

            })
            .catch(function (error) {
              console.log(error);
            });
        } else {
          self.errors = [];
          if (!self.name) {
            self.errors.push("Company Name Required");
          }
          if (!self.email) {
            self.errors.push("Email Address Required");
          }
          if (!self.password) {
            self.errors.push("Password Phone is Required");
          }
          e.preventDefault();
        }
      }
    }
  }
</script>