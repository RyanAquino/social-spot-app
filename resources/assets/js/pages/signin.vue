<template>
    <div class="container">
        <div class="alert alert-danger" v-if="errors.length">
			<p class="text-center" v-for="(error,index) in errors" :key="index"> {{ error }} </p>
		</div>
        <div class="card">
                <div class="card-header text-center">Sign In</div>
				<div class="card-body">
					<form v-on:submit.prevent="onSubmit">
					  <div class="form-group">
					    <label for="email">Email Address</label>
					    <input type="email" name="email" class="form-control" id="email" v-model="email" required>
					  </div>

					  <div class="form-group">
					    <label for="password">Password</label>
					    <input type="password" name="password" class="form-control" v-model="password" required>
					  </div>
                      
                      <div class="d-flex justify-content-center">
					    <button type="submit" class="btn btn-lg btn-success text-center">Login</button>
                      </div>
					</form>
				</div>
			</div>
    </div>
</template>

<script>
export default {
	name:'signin',
	props:['app'],
	data(){
		return {
            email:'',
            password:'',
			errors:[]
		}
    },
    methods: {
        async onSubmit(){
            this.errors = [];

            if(!this.email || !this.password){
				this.errors.push('Please fill out required fields');
				return;
			}

            const data = {
				email: this.email,
				password: this.password
			}
            
            const req = await fetch('http://localhost:8000/api/auth/signin',{
				method:'POST',
				headers: {
					'Content-type': 'application/json',
					'Accept': 'application/json'
				},
				body: JSON.stringify(data)
			});

            const response = await req.json();
            
            if(response.Error){
                this.errors.push(response.Error);
				return;
			}
			this.app.token = response.token;
			localStorage.setItem('token', this.app.token);
			this.$router.push('/home');
        }
    }
}
</script>