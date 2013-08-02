<?php
namespace Album ;

// Use Service Manager to configure the table gateway and inject into the AlbumTable
use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
//--

class Module {
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
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


    
    /*
     * http://framework.zend.com/manual/2.2/en/user-guide/database-and-models.html
     * 
     * We want to use the same instance of AlbumTable,
     * In OOP a factory is an abstraction of a constructor used to create an object; like a singleton which restricts the instatiantion of a class into one object.
     * To do that, we must configure the Service Manager via conviguration where we define HOW we create one. (http://framework.zend.com/manual/2.2/en/modules/zend.service-manager.lazy-services.html)
     * The method getServiceConfig is automatically called by the ModuleManager and applied to the ServiceManager
     * 
     * This method returns an array of factories that are all merged together by the ModuleManager before passing to the ServiceManager. 
     * The factory for Album\Model\AlbumTable uses the ServiceManager to create an AlbumTableGateway to pass to the AlbumTable. 
     * We also tell the ServiceManager that an AlbumTableGateway is created by getting a Zend\Db\Adapter\Adapter (also from the ServiceManager) 
     * and using it to create a TableGateway object. The TableGateway is told to use an Album object whenever it creates a new result row. 
     * The TableGateway classes use the prototype pattern for creation of result sets and entities. This means that instead of instantiating when required, 
     * the system clones a previously instantiated object.
     */
     public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Album\Model\AlbumTable' =>  function($sm) {
                    $tableGateway = $sm->get('AlbumTableGateway');
                    $table = new AlbumTable($tableGateway);
                    return $table;
                },
                'AlbumTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

    
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
