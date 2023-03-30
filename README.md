# Task list - Test #

This is a test for todosistemas and it consist in create a CRUD for task where you can create a task and asign an employe to solve that task.

It project was developed in PHP using Laravel, bootstrap and some libraries of js like databale.

## download projets

You have to execute the next command to get the project 
```
git clone https://github.com/orjuela45/todosistemas-test.git
```
and then you have to enter to the folder that you donwload to prepare the enviroment

## Prepare enviroment ##

in this section it explain how prepare the enviroment and how to run it:

1. install packages
You have to install the package necessaries to run the project, use the command 
```
composer install
```

1. Configure .env file
You have to configure the env file, you can copy the file .env.example and remove the .example part

2. Create a database

If you have Docker you can execute the next command to create the database.
```
docker-compose up -d
```

if you want to use mysql you have to create a new database and put the credentials in the file .env

3. Migrate tables

To create the tables that the project need you have to run the next command
```
php artisan migrate
```

Note: check the database has the tables employes and tasks

4. Seed database 

To fill the tables with some data you have to run the next command
```
php artisan db:seed
```

5. Execute project.

Execute the comand to up the server 
```
php artisan serve
```