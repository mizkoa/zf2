<?php
/*
 * 
 */
return array(
  'controllers' => array(
        'invokables' => array(
            'BasicSchema\Controller\Index' => 'BasicSchema\Controller\IndexController', // <-- namespace of the module is defined here
        ),
    ),
    'router' => array( // <-- routes of this module are defined here
        'routes' => array(
                'BasicSchema' => array(
                    'type'    => 'literal', // types in Zend/Mvc documentation - routing - : http://framework.zend.com/manual/2.0/en/modules/zend.mvc.routing.html
                    'options' => array(
                        'route'    => '/basic',
                        'defaults' => array(
                            'controller' => 'BasicSchema\Controller\Index',
                            'action'     => 'index',
                        ),
                    ),
                ),
            ),
        ),
    'view_manager' => array(),
);

/**
 * return array(
  'controllers' => array(
        'invokables' => array(
            'User\Controller\Index' => 'User\Controller\IndexController', //
        ),
    ),
    'router' => array(
        'routes' => array(
                'user' => array(
                    'type'    => 'literal', // types in Zend/Mvc documentation - routing - 
                    'options' => array(
                        'route'    => '/user',
                        'defaults' => array(
                            'controller' => 'User\Controller\Index',
                            'action'     => 'index',
                        ),
                    ),
                ),
            ),
        ),
    'view_manager' => array(),
    
);
 */
?>
