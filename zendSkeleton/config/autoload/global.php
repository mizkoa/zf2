<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
//<!--
/**
 * we need to configure the ServiceManager so that it knows how to get a Zend\Db\Adapter\Adapter. 
 * This is done using a factory called Zend\Db\Adapter\AdapterServiceFactory which we can configure within the merged config system. 
 * Zend Framework 2’s ModuleManager merges all the configuration from each module’s module.config.php file and then merges in the files in config/autoload 
 * (*.global.php and then *.local.php files). 
 * We’ll add our database configuration information to global.php which you should commit to your version control system. 
 * You can use local.php (outside of the VCS) to store the credentials for your database if you want to. 
 * Modify config/autoload/global.php (in the Zend Skeleton root, not inside the Album module) 
 */
return array(
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=zf2tutorial;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    // DOCTRINE: USER, PASSWORD MUST GO ON LOCAL
    'doctrine' => array(
        'connection' => array(
          'orm_default' => array(
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                  'host'     => 'localhost',
                  'port'     => '3306',
                  'dbname'   => 'zf2tutorial',
    ))))
);

