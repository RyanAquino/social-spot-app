<template>
    <div class="card mt-5 mb-5">
        <div class="card-body">
            <form v-on:submit.prevent="addPost">
                <div class="form-group">
                    <label for="name">Create post</label>
                    <textarea class="form-control"  v-model="post" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success text-center">Add post</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name:'postform',
	data(){
		return {
            post:'',
			errors:[],
			success:false
		}
    },
    methods: {
        async addPost(){
            console.log('posted!');
        }
    }
}
</script>

