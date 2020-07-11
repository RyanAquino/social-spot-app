<template>
    <div class="container">
        <h3 class="text-center">My Recent Posts</h3>
        <div class="d-flex justify-content-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="card card-body mb-2" v-for="post in this.posts" v-bind:key="post.id">
                <p>{{ post.body}}</p>
        </div>
    </div>
</template>

<script>
export default {
    name:'userPost',
    data(){
        return {
            posts: [],
            post: {
                id: '',
                body: '',
                likes:0,
            },
            loading:true,
            pagination:{},
        }
    },
    created(){
        this.getPosts();
    },
    mounted(){
      this.$root.$on('posted', (text) => {
        this.getPosts();
      });
    },
    methods: {
        async getPosts(){
            let token = localStorage.getItem('token');

            if(!token){
                console.log('no token');
                return;
            }

            const req = await fetch('http://localhost:8000/api/user/posts', {
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            });
            const resp = await req.json();

            this.posts = resp;
            this.loading = false;
        }
    }
}
</script>