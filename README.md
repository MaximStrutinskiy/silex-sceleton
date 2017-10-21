***Silex sceleton.***
````
- User registration, autorization.
- AdminLTE (Frontend plagin for admin panel)
- Customization security for API methods 
````

***Customize you DB connection: Create parameters.yml, add DB configuration.***
````
<?php
    $app->register(new \Silex\Provider\DoctrineServiceProvider(),[
        'db.options'=>[
            'driver' => 'pdo_mysql',
            'host' => 'custome_host',
            'dbname' => 'custome_dbname',
            'user' => 'custome_user',
            'password' => 'custome_password',
            'charset' => 'utf8',
        ]
    ]);
````

***Setup project***
````
Clone silex-sceleton to your folder:
$git clone repository.

Move to project folder:
$cd silex-sceleton/

Install all dependenses with composer:
$composer install

Create DB with tables 
$php bin/console orm:schema-tool:create 
 
Create test User
$php bin/console app:generate:user [email] [username] [password] [role]

example:
$php bin/console app:generate:user admin@admin.com admin admin admin
$php bin/console app:generate:user user@user.com user user user
````
***Command***
````
Doctrine Command Line Interface 2.5.13

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  help                            Displays help for a command
  list                            Lists commands
 app
  app:generate:user               Generate User. Set arguments: email, name, password, role. [email(string), name(string), password(string), role(bool) = 'admin' or 'user']
 dbal
  dbal:import                     Import SQL file(s) directly to Database.
  dbal:reserved-words             Checks if the current database contains identifiers that are reserved.
  dbal:run-sql                    Executes arbitrary SQL directly from the command line.
 orm
  orm:clear-cache:metadata        Clear all metadata cache of the various cache drivers.
  orm:clear-cache:query           Clear all query cache of the various cache drivers.
  orm:clear-cache:result          Clear all result cache of the various cache drivers.
  orm:convert-d1-schema           [orm:convert:d1-schema] Converts Doctrine 1.X schema into a Doctrine 2.X schema.
  orm:convert-mapping             [orm:convert:mapping] Convert mapping information between supported formats.
  orm:ensure-production-settings  Verify that Doctrine is properly configured for a production environment.
  orm:generate-entities           [orm:generate:entities] Generate entity classes and method stubs from your mapping information.
  orm:generate-proxies            [orm:generate:proxies] Generates proxy classes for entity classes.
  orm:generate-repositories       [orm:generate:repositories] Generate repository classes from your mapping information.
  orm:info                        Show basic information about all mapped entities
  orm:run-dql                     Executes arbitrary DQL directly from the command line.
  orm:schema-tool:create          Processes the schema and either create it directly on EntityManager Storage Connection or generate the SQL output.
  orm:schema-tool:drop            Drop the complete database schema of EntityManager Storage Connection or generate the corresponding SQL output.
  orm:schema-tool:update          Executes (or dumps) the SQL needed to update the database schema to match the current mapping metadata.
  orm:validate-schema             Validate the mapping files.
````


***Task***
````
- gulp for frontend
- security for API (use JWT tecnology)
- user actions (reset datas, registration, autorization)
- add validations for form
````