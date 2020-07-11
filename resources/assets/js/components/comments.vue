<template>
    <div>
        <div class="d-flex justify-content-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <ul class="list-group list-group-flush" v-for="(singlePost, index) in this.comments" :key="index">
            <li class="list-group-item" v-for=" (singleComment, i) in singlePost" v-bind:key="i"> 
                <div v-if="singleComment">
                    <p>{{ singleComment.comment}} </p>
                    <p><small>By: {{ singleComment.name}} </small></p>
                    <commentreply></commentreply>
                </div>
                <p v-else> No Comments yet  </p>
            </li>
        </ul>
    </div>
</template>


<script>
import commentreply from './commentreply';

export default {
    name:'comments',
    props: ['postid'],
    components: {
        commentreply
    },
    data(){
        return {
            comments:[],
            loading:false
        }
    },
    mounted(){
      this.$root.$on('commented', (text) => {
        this.getComments();
      })
    },
    created(){
        this.getComments();
    },
    methods: {
        async getComments(){
            this.loading = true;
            this.comments = [];
            let token = localStorage.getItem('token');

            if(!token){
                console.log('no token');
                return;
            }

            const req = await fetch(`http://localhost:8000/api/posts/${this.postid}/comments`, {
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            });
            const res = await req.json();
            this.comments.push(res);
            this.loading = false;
        }
    }   
}
</script>