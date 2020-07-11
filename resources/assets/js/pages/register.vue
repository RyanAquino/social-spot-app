<template>
    <div class="container">
		<div class="alert alert-danger" v-if="errors.length">
			<p class="text-center" v-for="(error,index) in errors" :key="index"> {{ error }} </p>
		</div>
		<div class="alert alert-success" role="alert" v-if="this.success">
			Successfully created!
		</div>
        <div class="card">
                <div class="card-header text-center">Register</div>
				<div class="card-body">
					<form v-on:submit.prevent="onSubmit">
					  <div class="form-group">
					    <label for="name">Full Name</label>
					    <input type="text" name="name" class="form-control" v-model="name" required>

					  </div>
					  <div class="form-group">
					    <label for="email">Email Address</label>
					    <input type="email" name="email" class="form-control" v-model="email" required>
					  </div>

					  <div class="form-group">
					    <label for="password">Password</label>
					    <input type="password" name="password" class="form-control" v-model="password" required>
					  </div>

					  <div class="form-group">
					    <label for="password">Verify Password</label>
					    <input type="password" name="password_verify" class="form-control" v-model="password_verify" required>
					  </div>
                      
                      <div class="d-flex justify-content-center">
					    <button type="submit" class="btn btn-lg btn-success text-center">Register
							<span v-if="loading" class="spinner-border" style="width: 1.5rem; height: 1.5rem;" role="status" aria-hidden="true"></span>
						</button>
                      </div>
					</form>
				</div>
			</div>
    </div>
</template>

<script>
export default {
	name:'register',
	props:['app'],
	data(){
		return {
			name:'',
			email:'',
			password:'',
			password_verify:'',
			errors:[],
			loading:false,
			success:false
		}
	},
	methods: {
		async onSubmit(){
			this.errors = [];
			this.loading = true;

			if(!this.name || !this.email || !this.password || !this.password_verify){
				this.errors.push('Please fill out required fields');
				return;
			}

			if(this.password != this.password_verify){
				this.errors.push('Password does not match');
				return;
			}

			const data = {
				name:this.name,
				email: this.email,
				password: this.password
			}

			const req = await fetch('http://localhost:8000/api/auth/signup',{
				method:'POST',
				headers: {
					'Content-type': 'application/json',
					'Accept': 'application/json'
				},
				body: JSON.stringify(data)
			});

			const response = await req.json();
			this.loading = false;
						
			if(response.Error){
				this.errors.push('Email already taken');
				return;
			}
			this.success = true;
			setTimeout(() => {
				this.$router.push('/login');
			}, 3000);
		}
	}
}
</script>