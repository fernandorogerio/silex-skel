<?php
use Doctrine\ORM\Tools\Setup,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\EventManager as EventManager,
    Doctrine\ORM\Events,
    Doctrine\ORM\Configuration,
    Doctrine\Common\Cache\ArrayCache as Cache,
    Doctrine\Common\Annotations\AnnotationRegistry, 
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\ClassLoader;

$loader = require __DIR__.'/vendor/autoload.php';
$loader->add('Skel', __DIR__.'/src');
// $loader->add('Coderockr', __DIR__.'/../coderockr/soa/src');

//doctrine
$config = new Configuration();
//$cache = new Cache();
$cache = new \Doctrine\Common\Cache\ApcCache();
$config->setQueryCacheImpl($cache);
$config->setProxyDir('/tmp');
$config->setProxyNamespace('EntityProxy');
$config->setAutoGenerateProxyClasses(true);
 
//mapping (example uses annotations, could be any of XML/YAML or plain PHP)
AnnotationRegistry::registerFile(__DIR__. DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . 'orm' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Doctrine' . DIRECTORY_SEPARATOR . 'ORM' . DIRECTORY_SEPARATOR . 'Mapping' . DIRECTORY_SEPARATOR . 'Driver' . DIRECTORY_SEPARATOR . 'DoctrineAnnotations.php');

\Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
    __DIR__ . '/vendor/jms/serializer/src/JMS/Serializer/Annotation/Type.php'
);

$driver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    new Doctrine\Common\Annotations\AnnotationReader(),
    array(__DIR__.'/src/Skel/Model')
);
$config->setMetadataDriverImpl($driver);
$config->setMetadataCacheImpl($cache);