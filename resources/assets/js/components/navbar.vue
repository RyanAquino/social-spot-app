<template>
    <div class="container">
        <nav class="navbar navbar-dark bg-primary rounded-lg">
        <a class="navbar-brand" href="/">Social Spot App</a>
        
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
            const token = localStorage.getItem('token');

            const req = await fetch('api/auth/signout', {
                method:'DELETE',
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            }).then(() => {
                this.app.token = null;
                localStorage.removeItem('token');
                this.$router.push('/login')
            });
        }
    }
}
</script>