
# DR Social Spot
A mini social media web application built with Laravel and Vue.js.


## Technology
* PHP
* JavaScript
* Vue
* Laravel
* JWT Authentication

## Setup
> Note: Make sure php/composer and node is installed
To run this project:
1. composer install
2. npm install
3. Setup/rename `.env.example` to `.env`
4. Set the following: \
`DB_DATABASE=social-spot` \
`DB_USERNAME=root` \
`DB_PASSWORD=`
5. Create database manually
6. Setup database tables - `php artisan migrate:refresh`
7. run the following commands: \
`php artisan key:generate` \
`php artisan jwt:secret`
8. Serve the application `php artisan serve`
9. Access the application `http://localhost:8000`
