# DatabaseSwiftMailerBundle

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dextervip/DatabaseSwiftMailerBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dextervip/DatabaseSwiftMailerBundle/?branch=master)

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

Register the bundle class and its dependencies in your AppKernel.php
```php
    public function registerBundles()
    {
        $bundles = array(
        ...
        new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
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

You may want to override the default template to have the look and feel of your application. You can do it by creating a new bundle and defining its parent as CitraxDatabaseSwiftMailerBundle.

1. Create a new empty bundle E.g. EmailBundle

2. Edit its bundle class and add a getParent() method returning 'CitraxDatabaseSwiftMailerBundle'

```php
class EmailBundle extends Bundle
{
    public function getParent()
    {
        return 'CitraxDatabaseSwiftMailerBundle';
    }
}
```

3. Create a twig template inside your new bundle in Resources/views/layout.html.twig and edit it to fit into your application layout. See the example below:

```twig
{% extends 'AppBundle::base.html.twig' %}

{% block title %}Email Spool{% endblock %}

{% block body %}
    {% block database_swiftmailer_content %}{% endblock %}
{% endblock %}
```

4. All done!



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

