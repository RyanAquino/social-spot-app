<template>
    <div class="container">
        <h3 class='text-center'>Friends</h3>
        <div class="d-flex justify-content-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <ul class="list-group">
            <li class="list-group-item" v-for="friend in this.friends" v-bind:key="friend.id">{{ friend.name}}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name:'posts',
    data(){
        return {
            friends:[],
            loading:true
        }
    },
    created(){
        this.getFriends();
    },
    methods: {
        async getFriends(){
            const token = localStorage.getItem('token');

            if(!token){
                return this.$routers.push('/login');
            }

            const req = await fetch('api/user/friends', {
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            });
            const resp = await req.json();
            this.friends = resp;
            this.loading = false;
        }
    }
}
</script>