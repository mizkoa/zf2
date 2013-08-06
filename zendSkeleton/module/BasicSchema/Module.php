<?php

/*
 * Basic autoloaders. 
 * DO NOT FORGET SET THE NEW MODULE IN config/application.config.php INTO THE MODULES ARRAY 
 *  'modules' => array(
 *      .....,
 *      'BasicSchema',
 *      
 *  )
 */
namespace BasicSchema;

class Module
{
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
}
?>
