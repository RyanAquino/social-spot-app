<template>
    <div>
        <navbar :app="this" class="mb-2 mt-2"></navbar>
        <router-view :app="this"/>
    </div>
</template>


<script>
import navbar from './components/navbar';

export default {
    name:'app',
    components: {
        navbar
    },
    data() {
        return {
            token:null,
            initiated:false,
        }
    },
    mounted(){
        this.init();
    },
    methods: {
        init(){
            const token_local = localStorage.getItem('token');

            if(token_local){
                this.token = token_local;
            }
            if(this.token && this.$route.fullPath == '/'){
                this.$router.push('/home');
            }
            if(!this.token  && this.$route.fullPath != '/login'){
                this.$router.push('/login');
            }
        }
    }
}
</script>

<style>
    body {
        background-color: #f5f5f5;
    }
</style>