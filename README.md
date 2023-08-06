# How to run DS_zadanie project
1. clone repo

2. run Docker

3. copy .env.docker-example and rename it to .env

4. run following in project's root:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

5. in project's root run command: "./vendor/bin/sail up"

6. in Docker, open ds_zadanie-laravel.test container's terminal

7. in that terminal run "php artisan migrate" -- [creating tables in DB]

8. in same terminal run "php artisan db:seed --class=DatabaseSeeder" -- [filling tables in DB]

9. in same terminal run "php artisan key:generate"

10. open http://localhost/ and log in (default user email: admin<span>@</span>admin.admin; password: admin)

# Available API endpoints
/api/get-categories<br>
(get all categories in JSON format)<br>
url: http://localhost/api/get-categories

/api/get-category/\{category_identifier\}<br>
(get specified category in JSON format by id or slug)<br>
example: http://localhost/api/get-category/1<br>
example: http://localhost/api/get-category/male-auta-1

/api/get-products<br>
(get all products in JSON format)<br>
url: http://localhost/api/get-products

/api/get-product/\{id\}<br>
(get specified product in JSON format by id)<br>
example: http://localhost/api/get-product/1

/api/get-category/\{category_identifier\}/products<br>
(get all products in specified category in JSON format by id or slug)<br>
example: http://localhost/api/get-category/1/products<br>
example: http://localhost/api/get-category/male-auta-1/products
