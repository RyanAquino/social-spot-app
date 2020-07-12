<template>
    <form class="form-inline mt-2"  v-on:submit.prevent="addReply">
        <div class="form-group mb-2">
            <label class="sr-only">reply</label>
            <input type="text" class="form-control" placeholder="reply here..." v-model="reply" required>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Add reply
            <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
    </form>
</template>

<script>
export default {
    name:'commentreply',
    props:['postid','commentid'],
    data(){
        return {
            reply:'',
            loading:false
        }
    },
    created(){
        
    },
    methods:{
        async addReply(){
            this.loading = true;
            let postId = this.postid;
            let commentId = this.commentid;
            let token = localStorage.getItem('token');

            if(!token){
                console.log('no token');
                return;
            }

            let data = {
                'reply': this.reply,
            };

            const req = await fetch(`api/posts/comments/${commentId}/reply`, {
                method:'POST',
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });
            const resp = await req.json();

            this.$root.$emit('replied', commentId);
            this.loading = false;
        }
    }
}
</script>