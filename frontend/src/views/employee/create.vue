<template>
    <div>
        <CCard>
            <CCardHeader>
                <h5>Add New Employee</h5>
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