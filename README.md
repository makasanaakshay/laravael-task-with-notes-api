## About Task App

Task app is created using laravel and sanctum package. This app's main functionality is provided API for user register and login and login user can creat multiple task with multiple notes and get task with filters.

## API List

- Register user
- Login
- Create task with notes
- Get tasks with filter options

## Installation

once you clone this repo. you have to run below command.

* Composer install
```
composer install
```
* Create a symbolic link from public/storage to storage/app/public.
```
  php artisan storage:link
```
* Create database and set to .env file.
* No run migration and seed database using below command.
```
php artisan migrate:fresh --seed
```
* Run below command to run project
```
php artisan serve
```
* Import postman API collection using below link.
  https://www.getpostman.com/collections/7612c1bda9073f8e71fb
## Test Credentials

When installation is completed you can login to test user using email : test@gmail.com and password : password
