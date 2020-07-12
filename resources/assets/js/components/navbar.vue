<template>
    <div class="container">
        <nav class="navbar navbar-dark bg-primary rounded-lg">
        <a class="navbar-brand" href="/">DR Social Spot</a>
        
        <form class="form">
            <div v-if="!this.app.token">
                <router-link to="/login" class="btn btn-primary ml-3">Sign In</router-link>
                <router-link to="/register" class="btn btn-primary ml-3">Sign Up</router-link>
            </div>
            <div v-else>
                 <router-link to="/home" class="btn btn-primary">Home</router-link>
                 <router-link to="/profile" class="btn btn-primary ml-2">Profile</router-link>
                <a href="javascript:;" @click="logout" class="btn btn-primary ml-5">Sign out</a>
            </div>
        </form>
        
        </nav>
    </div>
</template>

<script>
export default {
    name:'navbar',
    props: ['app'],
    data(){
        return {

        }
    },
    methods: {
        async logout() {
            const req = await fetch('http://localhost:8000/api/auth/signout').then(() => {
                this.app.token = null;
                localStorage.removeItem('token');
                this.$router.push('/login')
            });
        }
    }
}
</script>