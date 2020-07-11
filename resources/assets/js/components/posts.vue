<template>
    <div class="container">
        <h3 class="text-center">News feed</h3>
            <div class="d-flex justify-content-center" v-if="loading">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="card card-body mb-2" v-for="post in this.posts" v-bind:key="post.id">
                <p>{{ post.body}}</p>
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <comment v-bind:postid="post.id"></comment>
                    <button  type="submit" class="btn btn-info ml-4" @click="likePost(post.id, pagination.current_page)">
                            Likes: {{ post.likes }}
                    </button>
                </div>
                    <p>Comments:</p>
                    <comments v-bind:postid="post.id"></comments>

        </div>
        <nav aria-label="Page navigation example text-center">
            <ul class="pagination">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getPosts(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a href="" class="text-dark page-link">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getPosts(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>
    </div>
</template>

<script>
import comment from '../components/comment';
import comments from '../components/comments';

export default {
    name:'posts',
    props:['userHome'],
    components:{
        comment,
        comments
    },
    data(){
        return {
            posts: [],
            post: {
                id: '',
                body: '',
                likes:0,
            },
            loading:false,
            pagination:{},
        }
    },
    mounted(){
      this.$root.$on('posted', (text) => {
        this.getPosts();
      })
    },
    created(){
        this.getPosts();
    },
    methods: {
        async getPosts(page_url){
            this.loading = true;
            let vm = this;

            let token = localStorage.getItem('token');

            if(!token){
                console.log('no token');
                return;
            }
            page_url = page_url || '/api/posts';

            const req = await fetch(page_url, {
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            });
            const resp = await req.json();

            if(resp.message){
                console.log(resp.message);
                return;
            }
            this.posts = resp.data;
            vm.makePagination(resp.meta, resp.links);
            this.loading = false;
        },
        makePagination(meta, links){
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
            };

            this.pagination = pagination;
        },
        async likePost(id, page){
            this.loading = true;
            let token = localStorage.getItem('token');
            
            if(!token){
                console.log('no token');
                return;
            }

            const req = await fetch(`http://localhost:8000/api/posts/${id}/like`, {
                method:'PUT',
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            });
            const resp = await req.json();
            this.getPosts(`http://localhost:8000/api/posts?page=${page}`);
        }
    }
}
</script>