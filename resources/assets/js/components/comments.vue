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
                    <p><small>By: {{ singleComment.name }} </small></p>
                    <p><strong>Reply:</strong></p>
                    <li v-if="singleComment.reply">
                        <p>{{ singleComment.reply }}</p>
                        <p><small>By: {{ singleComment.user }} </small></p>
                    </li>
                    <commentreply v-else v-bind:postid="singlePost[i].post_id" v-bind:commentid="singleComment.id"></commentreply>
                </div>
                <p v-else> No Comments yet</p>
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
            replies: [],
            commentid:null,
            loading:false
        }
    },
    mounted(){
      this.$root.$on('commented', (text) => {
        this.getComments();
      });

      this.$root.$on('replied', (text) => {
        this.getComments();
      });
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
            for(let i=0; i < res.length; i++){
                let data = await this.getReply(res[i].id);
                if(data.Error){
                    continue
                }else{
                    res[i].reply = data.reply;
                    res[i].user = data.user;
                }
            }
            this.comments.push(res);
            this.loading = false;
        },
        async getReply(id){
            this.loading = true;
            let token = localStorage.getItem('token');

            if(!token){
                console.log('no token');
                return;
            }

            const req = await fetch(`http://localhost:8000/api/posts/comments/${id}/reply`, {
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            });
            const res = await req.json();

            if(res.message){
                return null;
            }

            return res;
        }
    }   
}
</script>