<?php
//configure mappings
return array(
'doctrine' => array(
  'driver' => array(
    'doctrineExp_entities' => array(
      'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
      'cache' => 'array',
      'paths' => array(__DIR__ . '/../src/DoctrineExp/Entity')
    ),

    'orm_default' => array(
      'drivers' => array(
        'DoctrineExp\Entity' => 'doctrineExp_entities'
      )
)))) // [...]

?>
