# IP Management API

## Installation

  ### Make sure you have docker installed

  1. Go to project directory
  2. run `docker compose build --no-cache`
  3. Once it is finished building run `docker compose up -d`
  4. Check the containers
  5. Go inside the app container via `docker compose exec app bash`
  6. Inside the container run `composer install`, `php artisan key:gen`
  7. Then go to http://localhost:8080
     #### once you see this 

     ```{"welcome":"ip_management"}```

     ### project is already installed
 8. Database config is on the .env.example you can modify that however you want
 9. Run tests  via `php artisan test` you should see all green


 ## API SPECS

  ### You can see the api specs on the `openapi.yaml` file
  ### Postman examples should be included as well 