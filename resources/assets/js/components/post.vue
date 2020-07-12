<template>
    <div>
        <p>
            {{ this.post.body }}
        </p>
        <p v-if="this.user"><small>Posted by: {{ this.user }} ({{ this.email }})</small></p>
        <p v-else>Loading...</p>
    </div>
</template>

<script>
export default {
    name:'postitem',
    props:['post'],
    data() {
        return {
            user: '',
            email: ''
        }
    },
    mounted(){
        this.getUser(this.post.user_id);
    },
    methods: {
        async getUser(id){
            let token = localStorage.getItem('token');

            if(!token){
                console.log('no token');
                return;
            }

            const req = await fetch(`api/user/profile/${id}`, {
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            });

            const resp = await req.json();
            this.user = resp.name;
            this.email = resp.email
        }
    }
}
</script>

<style scoped>
    p {
        margin:0;
    }
</style>