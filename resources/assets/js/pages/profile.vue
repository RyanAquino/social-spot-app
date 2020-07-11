<template>
    <div class="container">
        <div class="col-12">
            <div class="row">
            <div class="col-6">
                <div class="alert alert-danger" v-if="errors.length">
                    <p class="text-center" v-for="(error,index) in errors" :key="index"> {{ error }} </p>
                </div>
                <div class="alert alert-success" role="alert" v-if="this.success">
                    Successfully updated!
                </div>
                <div class="card mt-5">
                    <div class="card-header text-center">My Profile</div>
                    <div class="card-body">
                        <form v-on:submit.prevent="onSubmit">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" class="form-control" v-model="name">

                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" class="form-control" v-model="email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" v-model="password">
                        </div>

                        <div class="form-group">
                            <label for="password">Verify Password</label>
                            <input type="password" name="password_verify" class="form-control" v-model="password_verify">
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success text-center">
                                Update profile
                                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                            
                        </div>
                        </form>
                    </div>
                </div>
                <postform></postform>
            </div>
            <div class="col-6">
                <userpost></userpost>
            </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import userpost from '../components/userpost';
import postform from '../components/postform';

export default {
    name:'register',
	data(){
		return {
			name:'',
			email:'',
            password:'',
            password_verify:'',
            post:'',
            errors:[],
            loading: false,
			success:false
		}
    },
    components: {
        userpost,
        postform
    },
    created(){
        this.getProfile();
    },
	methods: {
        async onSubmit(e){
            this.loading = true;
            let token = localStorage.getItem('token');

            if(!token){
                console.log('no token');
                return;
            }

            if(this.password != this.password_verify){
				this.errors.push('Password does not match');
				return;
			}

            let data = {
                name: this.name,
                email: this.email,
                password: this.password
            }

            const req = await fetch('http://localhost:8000/api/user/profile/update',{
				method:'POST',
				headers: {
					'Content-type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization' : `Bearer ${token}`
				},
				body: JSON.stringify(data)
			});

            const response = await req.json();
            this.success = true;
            this.loading = false;

        },
        async getProfile(){
            let token = localStorage.getItem('token');

            if(!token){
                console.log('no token');
                return;
            }

            const req = await fetch('http://localhost:8000/api/user/profile', {
                headers: {
                    "Accept": "application/json",
                    'Content-type': "application/json",
                    'Authorization': `Bearer ${token}`
                }
            });

            const resp = await req.json();
            this.name = resp.name;
            this.email = resp.email;
        }
    }
}
</script>