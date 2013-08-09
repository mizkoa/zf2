<?php
/*
 * It describes the routes for the User module
 * User's routes are set individually, and messages routers are set scaled, root and children. 
 * Second way looks better but trying both ways anyway
 * 
 * @mrod
 * 08.2013
 */
return array(
  'controllers' => array(
        'invokables' => array(
            'User\Controller\Index' => 'User\Controller\IndexController', // <-- namespace of the module is defined here
        ),
    ),
    'router' => array( // <-- routes of this module are defined here
        'routes' => array(
                'users' => array( //<-- 'user' is the name to get the url using  $this->url('user', array(...));
                    'type'    => 'literal', // types in Zend/Mvc documentation - routing - : http://framework.zend.com/manual/2.0/en/modules/zend.mvc.routing.html
                    'options' => array(
                        'route'    => '/users',
                        'defaults' => array(
                            'controller' => 'User\Controller\Index',
                            'action'     => 'showUsers',
                        ),
                    ),
                ),
                'user_add' => array( //<-- 
                    'type'    => 'literal', // types in Zend/Mvc documentation - routing - : http://framework.zend.com/manual/2.0/en/modules/zend.mvc.routing.html
                    'options' => array(
                        'route'    => '/user/add',
                        'defaults' => array(
                            'controller' => 'User\Controller\Index',
                            'action'     => 'addUser',
                        ),
                    ),
                ),
                'user_del' => array( //<-- 
                        'type'    => 'segment', // types in Zend/Mvc documentation - routing - : http://framework.zend.com/manual/2.0/en/modules/zend.mvc.routing.html
                        'options' => array(
                            'route'    => '/user/delete/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\Index',
                                'action'     => 'deleteUser',
                            ),
                        ),
                    ),
                'user_del_mess' =>array( //<-- //deletes message from user
                        'type'    => 'segment', 
                        'options' => array(
                            'route'    => '/user/delete/message/:id_user/:id_message',
                            'constraints' => array(
                                'id_user'     => '[0-9]+',
                                'id_message'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\Index',
                                'action'     => 'disassociateMessage',
                            ),
                        ),
                    ),
            // another way to do the user rooting is "childing" roots from their father (like user/add, user/delete) in the same description. We will do messages that way
                 'messages' => array( 
                        'type'    => 'literal', 
                        'options' => array(
                            'route'    => '/messages',
                            'defaults' => array(
                                'controller' => 'User\Controller\Index',
                                'action'     => 'showMessages',
                            ),
                        ),
                       'may_terminate' => true, //<-- if false or not indicated, upper action never will be executed and it will trigger the child route
                       'child_routes' => array(
                            'message_delete' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/delete/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'User\Controller\Index',
                                        'action'     => 'deleteMessages',
                                    ),
                                ),
                            ),
                            'message_add' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/add',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'controller' => 'User\Controller\Index',
                                        'action'     => 'addMessages',
                                    ),
                                ),
                            ),
                           'mess_del_user' =>array( //<-- //deletes message from user
                                'type'    => 'segment', 
                                'options' => array(
                                    'route'    => '/delete/user/:id_user/:id_message',
                                    'constraints' => array(
                                        'id_user'     => '[0-9]+',
                                        'id_message'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'User\Controller\Index',
                                        'action'     => 'disassociateUser',
                                    ),
                                ),
                            )
                        ),
            ),
            'user_message' => array( //<-- 
                'type'    => 'segment', // types in Zend/Mvc documentation - routing - : http://framework.zend.com/manual/2.0/en/modules/zend.mvc.routing.html
                'options' => array(
                    'route'    => '/user-message',
                    'constraints' => array(),
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action'     => 'addUserMessage',
                    ),
                ),
            ),
            'message_user' => array( //<-- 
                'type'    => 'segment', // types in Zend/Mvc documentation - routing - : http://framework.zend.com/manual/2.0/en/modules/zend.mvc.routing.html
                'options' => array(
                    'route'    => '/message-user',
                    'constraints' => array(),
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action'     => 'addMessageUser',
                    ),
                ),
            ),
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
