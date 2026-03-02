# GegoK12

#### Version 1.0


### Pre-Requestie
1. Install "Laragon" or "XAMPP" or similar PHP Dev Platform
2. MySQL
3. Redis (Optional)
4. Node (v 24)
5. Php 8.4

## How to Install

1. Pull the Repo from the GitLab
2. Run "composer install"
3. Run "npm install"
4. Duplicate .env.example file as .env
5. Add your mysql db details there
6. Run Migration as -- "php artisan migrate"
7. Populate Data as -- "php artisan db:seed"
8. php artisan passport:install


# Docker Commands
   Install Docker 

1. Duplicate .env.example file as .env
2. docker-compose up -d --build
3. docker exec -it school_app bash
     -Run "composer install"
     -Run Migration as -- "php artisan migrate"
     -Populate Data as -- "php artisan db:seed"
4. docker exec -it node_app npm install     
5. http://localhost:8090/