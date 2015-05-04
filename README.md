# DatabaseSwiftMailerBundle
## Introduction

This bundle add a database driven swiftmailer spool to your symfony 2 project. It requires Symfony 2.4+ and usage of entities with Doctrine ORM.

### Features

- Auto Retrying: set a maximum number of retries that spool will try to send in case of failure
- Dashboard to list the email spool and perform some actions
- Retry sending an email
- Cancelling an email sending 
- Resending an email

## Installing

### Add composer

Add the dependency to your composer.json

```yml
    "require": {
        ...
	    "dextervip/database-swiftmalier-bundle" : "dev-master"
	}
```

### Add bundle class in kernel

Register the bundle class in your AppKernel.php
```php
    public function registerBundles()
    {
        $bundles = array(
        ...
        new Citrax\Bundle\DatabaseSwiftMailerBundle\CitraxDatabaseSwiftMailerBundle(),
        ...
        );
    }
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

### Overriding default templates 

### Extra config

??


## Running

To send emails that are in the database spool, just run the following command: 

```sh
$ php app/console swiftmailer:spool:send
```

You may add a cron job entry to run it periodically.

You can check the spool status with all emails at http://your_project_url/email-spool


## To Do's

- Filter emails


## License
MIT

