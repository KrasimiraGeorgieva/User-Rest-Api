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
1. Clone or download project from https://github.com/KrasimiraGeorgieva/User-Rest-Api.git
2. Go into the root directory of the project (where the bin folder resides)
3. Make sure you’ve started your MySQL server (either from XAMPP or standalone)
4. Open a shell / command prompt / PowerShell window in that directory (shift + right click --> open command window here)
5. Enter the `php composer.phar install` or `composer install` command to restore its **Composer** dependencies (described in `composer.json`)

5.1. In case you have composer globaly and enter command `composer install` you have to provide parameters from parameters.yml manual
* database_port - press `Enter`
* database_name - press `Enter`
* database_root - press `Enter`
* database_password - press `Enter` or `enter the password`
* mailer_transport - press `Enter`
* mailer_host - press `Enter`
* mailer_user - press `Enter`
* mailer_password - press `Enter`
* secret - press `Enter`

6. Enter the `php bin/console doctrine:database:create` command
7. Enter the `php bin/console doctrine:schema:update --force` command
8. Enter the `php bin/console server:run` (Windows OS) or `php bin/console server:start` (MAC OS) command
9. Done!

### Auto Steps
1. Clone or download project from https://github.com/KrasimiraGeorgieva/User-Rest-Api.git
2. Go into the root directory of the project (where the bin folder resides)
3. Make sure you’ve started your MySQL server (either from XAMPP or standalone)
4. Run `init-db.bat` file - for Windows OS
5. Done!

### Running Project Tests

1. Make sure you’ve started your MySQL server (either from XAMPP or standalone).
2. Open a shell / command prompt / PowerShell window in that directory (shift + right click --> open command window here) from root directory of the project (where the bin folder resides)
3. Enter `.\vendor\bin\phpunit` or `vendor\bin\phpunit tests` command
4. Done!

### Postman
The **User API** can be used by Postman app.

### Method | Route
```
-----------------------------------------------------------------------------
|GET	|	/api/v1/users 	 	|	Retrieves a list of users				|
|POST	|	/api/v1/users 		|	Creates a new user						|
|GET 	|	/api/v1/users/{id}	|	Retrieves a specific user by id			|
|PUT	|	/api/v1/users/{id}	|	Updates user by id						|
|DELETE	|	/api/v1/users/{id}	|	Deletes user by id						|
-----------------------------------------------------------------------------
```