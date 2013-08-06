<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace BasicSchema\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        echo "<h1>Hallo Welt! Viele Grüße! </h1>" ;
        return true ;
    }
}

?>
