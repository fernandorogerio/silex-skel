<?php

$loader = require __DIR__.'/vendor/autoload.php';
$loader->add('Orcamentos', __DIR__.'/src');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationRegistry;

AnnotationRegistry::registerFile(__DIR__.'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

\Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
    __DIR__ . '/vendor/jms/serializer/src/JMS/Serializer/Annotation/Type.php'
);

// configuration (2)
$config = new \Doctrine\ORM\Configuration();

// Proxies (3)
$config->setProxyDir(__DIR__ . '/tmp');
$config->setProxyNamespace('Proxies');
$config->setAutoGenerateProxyClasses(true);

// Driver (4)
$driverImpl = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    new Doctrine\Common\Annotations\AnnotationReader(),
    array(__DIR__.'/src/Skel/Model')
);
$config->setMetadataDriverImpl($driverImpl);

$cache = new \Doctrine\Common\Cache\ApcCache();

$config->setMetadataCacheImpl($cache);

$connectionOptions = array(
    'driver' => 'pdo_mysql',
    'user' => 'skel',
    'password' => 'skel',
    'dbname' => 'skel',
    'host' => '127.0.0.1'
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

return $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));
