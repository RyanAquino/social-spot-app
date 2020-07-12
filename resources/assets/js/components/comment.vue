<template>
    <form class="form-inline mt-2"  v-on:submit.prevent="addComment">
        <div class="form-group mb-2">
            <label class="sr-only">comment</label>
            <input type="text" class="form-control" placeholder="comment here..." v-model="comment">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Add comment
            <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
    </form>
</template>

<script>

export default {
    name:'comment',
    props:['postid'],
    data(){
        return {
            comment:'',
            loading:false
        }
    },
    methods: {
        async addComment(){
            this.loading = true;
            if(!this.comment){
                alert('field required');
                return;
            }

            let token = localStorage.getItem('token');

            if(!token){
                alert('not authenticated');
                this.app.token = null;
                return this.$router.push('/login');
            }

            let data = {
                comment:this.comment
            };

            const req = await fetch(`http://localhost:8000/api/posts/${this.postid}/comment`, {
                method:'POST',
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });

            const resp = await req.json();
            this.comment = '';
            this.$root.$emit('commented', 'new comment!');
            this.loading = false;
            
        }
    }
}
</script>