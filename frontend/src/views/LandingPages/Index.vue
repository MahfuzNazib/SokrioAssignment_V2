<template>
    <div>
        <div class="container bg card">
            <span class="mt-5 mb-5">
                <span class="float-right">
                    <router-link :to="{path:'/login'}">
                        <button class="btn btn-info">Login</button>
                    </router-link>
                </span>
                <span class="float-right">
                    <router-link :to="{path:'/register'}">
                        <button class="btn btn-primary mr-3">Company Registration</button>
                    </router-link>
                </span>
                <center>
                    <h1>Attendance Management System</h1>
                </center>
            </span>
        </div>
    </div>
</template>