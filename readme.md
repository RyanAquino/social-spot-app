
# Social Spot App
A mini social media web application built with Laravel and Vue.js hosted on heroku with PostgreSQL database.


## Technology
* PHP Laravel
* JavaScript Vue
* Bootstrap
* PosgreSQL
* JWT Authentication
* Docker & Docker compose

## Setup
> Note: Make sure php/composer and node is installed before proceeding
#### Install dependencies
```
composer install && npm install
```

#### Create environment config file
```
cp .env.example .env
```
#### Modify the following configurations based on needs
```
DB_DATABASE=social-spot
DB_USERNAME=postgres
DB_PASSWORD=1
```
#### Create datbase manually
#### Run migrations
```
php artisan migrate:refresh
```

#### Generate keys 
```
php artisan key:generate && php artisan jwt:secret
```

#### Serve application
```
php artisan serve
```

## Docker setup
#### Run services 
```
docker-compose up
```

#### Migrate database tables
```
docker exec -it social-spot-app php artisan migrate:refresh
```


## Access application
```
http://localhost:8000
```