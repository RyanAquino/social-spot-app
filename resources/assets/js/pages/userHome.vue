<template>
    <div class="container">
        <h1 class="text-center">Welcome User!</h1>
        <div class="row">
            <div class="col-6">
                <posts>
                </posts>
            </div>
            <div class="col-6">
                <postform :app="this.app"></postform>
                <friends></friends>
            </div>
        </div>
    </div>
</template>

<script>
import posts from '../components/posts';
import friends from '../components/friends';
import postform from '../components/postform';


export default {
    name:'userHome',
    props:['app'],
    components: {
        posts,
        friends,
        postform
    }
}
</script>