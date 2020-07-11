<template>
    <form class="form-inline mt-2"  v-on:submit.prevent="addReply">
        <div class="form-group mb-2">
            <label class="sr-only">reply</label>
            <input type="text" class="form-control" placeholder="comment here..." v-model="reply">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Add reply
            <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
    </form>
</template>

<script>
export default {
    name:'commentreply',
    data(){
        return {
            reply:'',
            loading:false
        }
    },
    methods:{
        addReply(){
            this.loading = true;
            console.log('test');
            this.loading = false;
        }
    }
}
</script>