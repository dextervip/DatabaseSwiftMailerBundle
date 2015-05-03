# DatabaseSwiftMailerBundle
## Introduction

This bundles add a database driven spool to your project. 

## Installing

### Add composer


### Add bundle class in kernel

Register the bundle class in your AppKernel.php
```php
    ...
    new Citrax\Bundle\DatabaseSwiftMailerBundle\CitraxDatabaseSwiftMailerBundle(),
    ...
```

### Add routes

If you want to have a spool dashboard, add the following routes.

```yml
citrax_database_swift_mailer:
    resource: "@CitraxDatabaseSwiftMailerBundle/Controller/"
    type:     annotation
    prefix:   /
```

## Configuring

### Update database

Update your database schema to create the necessary entities.

```sh
$ php app/console doctrine:schema:update --force
```

### Update swiftmailer config

Change your spool type from memory to db in your config.yml

```yml
    spool:     { type: db }
```

### Extra config

??


## Running

To send emails that are in the database spool, just run the following command: 

```sh
$ php app/console swiftmailer:spool:send
```

You may add a cron job entry to run it periodically.

You can check the spool status with all emails at http://your_project_url/email-spool



## License
MIT

