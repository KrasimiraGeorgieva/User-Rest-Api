# User RESTfull api

**https://api.user.krasimira-georgieva.com/**

## Build technologies:

### PHP
* **Symfony** framework
* **Doctrine** ORM
* **MySQL** database

## Setup
Make sure you download all the dependencies (packages) required for the technology and set up the databases! Below are instructions on how to do this:

### Manual Steps
1. Go into the root directory of the project (where the bin folder resides)
2. Make sure you’ve started your MySQL server (either from XAMPP or standalone)
3. Open a shell / command prompt / PowerShell window in that directory (shift + right click --> open command window here)
4. Enter the `php composer.phar install` or `php composer install` - if you have installed it globaly, command to restore its **Composer** dependencies (described in `composer.json`)
5. Enter the `php bin/console doctrine:database:create` command
6. Done!

### Auto
1. Run init-db.bat file - for Windows OS

### Run Tests

1.
2.
3.

### Postman
The **User API** can be used by Postman.

### Method => Route
GET		=>  /api/v1/users - Retrieves a list of users
POST	=>	/api/v1/users - Creates a new user
GET 	=>	/api/v1/users/{id} - Retrieves a specific user by id
PUT		=>	/api/v1/users/{id} - Updates user by id
DELETE	=>	/api/v1/users/{id} - Deletes user by id