# UberServices

installation :

$ git clone {the repo link}

inside laravel project: $ composer install ... $ cp .env.example .env then configure your db parameters in .env file...
create db... $ php artisan migrate

Web Services:
1) get all monopolists ( As visitor ) 
Method: GET,
Url: http://localhost/Path-to-project/public/api/v1/guest/drivers/monopolists

2) Register ( As driver ) 
Method: POST,
Url: http://localhost/Path-to-project/public/api/v1/guest/register
Request object: {name , email , password , password_confirmation}

3) login ( As driver ) 
Method: POST,
Url: http://localhost/Path-to-project/public/api/v1/guest/authenticate
Request object: {email , password}

4) makr trip ( As driver ) 
Method: POST,
Url: http://localhost/Path-to-project/public/api/v1/driver/new-trip
header: Authorization : Bearer + token generated from login
Request object: {}

5) run >> php artisan schedule:run .. to start scheduler

