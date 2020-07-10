<template>
    <div class="container">
        <h3 class="text-center">News feed</h3>
        <div class="card card-body mb-2" v-for="post in this.posts" v-bind:key="post.id">
                <p>{{ post.body}}</p>
                <button class="btn btn-info" @click="likePost(post.id, pagination.current_page)">Like {{ post.likes }}</button>
                <form class="form-inline mt-2"  v-on:submit.prevent="">
                    <div class="form-group mb-2">
                        <label for="comment" class="sr-only">comment</label>
                        <input type="password" class="form-control" id="comment" placeholder="comment here...">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Add comment</button>
                </form>

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
export default {
    name:'posts',
    props:['userHome'],
    data(){
        return {
            posts: [],
            post: {
                id: '',
                body: '',
                likes:0,
            },
            pagination:{},
        }
    },
    created(){
        this.getPosts();
    },
    methods: {
        async getPosts(page_url){
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