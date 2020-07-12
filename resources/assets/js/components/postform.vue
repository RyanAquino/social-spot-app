<template>
    <div class="card mt-5 mb-5">
        <div class="card-body">
            <form v-on:submit.prevent="addPost">
                <div class="form-group">
                    <label for="name">Create post</label>
                    <textarea class="form-control"  v-model="post" id="exampleFormControlTextarea1" rows="3" required></textarea>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success text-center">
                        Add post
                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name:'postform',
    props:['app'],
	data(){
		return {
            post:'',
			errors:[],
            success:false,
            loading:false
		}
    },
    methods: {
        async addPost(){
            this.loading = true;
            const token = localStorage.getItem('token');

            if(!token){
                alert('not authenticated');
                this.app.token = null;
                return this.$router.push('/login');
            }

            if(!this.post){
                alert('field is required');
                return;
            }

            let data = {
                body:this.post
            };

            const req = await fetch('http://localhost:8000/api/posts', {
                method:'POST',
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });

            const resp = await req.json();
            
            this.$root.$emit('posted', 'new message!');
            this.loading = false;
            this.post = '';
        }
    }
}
</script>

