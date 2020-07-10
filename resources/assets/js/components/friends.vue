<template>
    <div class="container">
        <h3 class='text-center'>Friends</h3>
        <ul class="list-group">
            <li class="list-group-item" v-for="friend in this.friends" v-bind:key="friend.id">{{ friend.name}}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name:'posts',
    props:['userHome'],
    data(){
        return {
            friends:[]
        }
    },
    created(){
        this.getFriends();
    },
    methods: {
        async getFriends(){
            let token = localStorage.getItem('token');

            if(!token){
                return this.$routers.push('/login');
            }

            const req = await fetch('http://localhost:8000/api/user/friends', {
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            });
            const resp = await req.json();
            this.friends = resp;
        }
    }
}
</script>