<?php
/*
 * 
 */
return array(
  'controllers' => array(
        'invokables' => array(
            'User\Controller\Index' => 'User\Controller\IndexController', // <-- namespace of the module is defined here
        ),
    ),
    'router' => array( // <-- routes of this module are defined here
        'routes' => array(
                'user' => array( //<-- 'user' is the name to get the url using  $this->url('user', array(...));
                    'type'    => 'literal', // types in Zend/Mvc documentation - routing - : http://framework.zend.com/manual/2.0/en/modules/zend.mvc.routing.html
                    'options' => array(
                        'route'    => '/users',
                        'defaults' => array(
                            'controller' => 'User\Controller\Index',
                            'action'     => 'index',
                        ),
                    ),
                ),
                'user_add' => array( //<-- 
                    'type'    => 'literal', // types in Zend/Mvc documentation - routing - : http://framework.zend.com/manual/2.0/en/modules/zend.mvc.routing.html
                    'options' => array(
                        'route'    => '/add',
                        'defaults' => array(
                            'controller' => 'User\Controller\Index',
                            'action'     => 'add',
                        ),
                    ),
                ),
                'user_del' => array( //<-- 
                        'type'    => 'segment', // types in Zend/Mvc documentation - routing - : http://framework.zend.com/manual/2.0/en/modules/zend.mvc.routing.html
                        'options' => array(
                            'route'    => '/delete/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\Index',
                                'action'     => 'delete',
                            ),
                        ),
                    ),
            /**/
            
            
            ),
        ),
    'view_manager' => array(),
    //DOBTRINES DRIVERS
    'doctrine' => array(
        'driver' => array(
          'user_entities' => array(
            'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            'cache' => 'array',
            'paths' => array(__DIR__ . '/../src/User/Entity')
          ),

          'orm_default' => array(
            'drivers' => array(
                    'User\Entity' => 'user_entities'
                )
            )
        )
    ),
);

?>
