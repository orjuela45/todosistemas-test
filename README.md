# Task list - Test #

This is a test for todosistemas and it consist in create a CRUD for task where you can create a task and asign an employe to solve that task.

It project was developed in PHP using Laravel, bootstrap and some libraries of js like databale.

## download projets

You have to execute the next command to get the project 
```

```
and then you have to enter to the folder that you donwload to prepare the enviroment

## Prepare enviroment ##

in this section it explain how prepare the enviroment and how to run it:

1. Create a database

If you have Docker you can execute the command docker-compose up -d to create the database. But if you want to use mysql you have to create a new database and put the credentials in the file .env

2. Migrate tables

To create the tables that the project need you have to run the next command
```
php artisan migrate
```

Note: check the database has the tables employes and tasks

3. Seed database 

To fill the tables with some data you have to run the next command
```
php artisan db:seed
```

4. Execute project.

Execute the comand to up the server 
```
php artisan serve
```