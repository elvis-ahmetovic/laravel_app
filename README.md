# Laravel App

The same idea as my final exam done with Laravel, for the purpose of practice and learning.

## Description

The app is meant to people who need sports coach. They can search coach by category, city where they live or price range. After registration on app they can contact coach through private message system, make relations and leave reviews.

### Getting started

Configuration on xampp

#### 1. Clone

Clone this repository

#### 2. Config virtual hosts

##### Setting apache virtual host

Open ``` httpd-vhost.conf ``` file in ``` C:\xampp\apache\conf\extra\ ``` directory and add following code at the end of the file: 


```
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/laravel_app/public"
    ServerName up.test
</VirtualHost>
```

##### Edit windows host file

Open ``` hosts ``` file in ``` C:\windows\system32\drivers\etc\ ``` directory. You will need Administrator privilege to edit the file.

 Add following code at the end of the file: 
 ``` 127.0.0.1       up.test ```

 ##### Final step, restart your Apache server.

 #### 3. Install NPM Dependencies

 Run ``` npm install ```

 #### 4. Create a copy of your .env file

 Run ``` cp .env.example .env ```

 #### 5. Setup Database

 * Create database with phpmyadmin or MySQL Workbench, with name ``` up ```

 * Open the ``` .env ``` file and add your credentials

 ```
 DB_HOST=localhost
 DB_DATABASE=up
 DB_USERNAME= // Your username
 DB_PASSWORD= // Your password
 ```

 #### 6. Create the symbolic link

 Run ``` php artisan storage:link ```

 #### 7. Migrate the database

 Run ``` php artisan migrate ```

 #### 8. Seed the database

 Run ``` php artisan db:seed ```

 #### 9. Run the project

 Run in your browser ``` up.test ```