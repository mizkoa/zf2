<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        // USER
        echo "<h1>User </h1>";
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
       // $objectManager =  $this->getEntityManager();
        // one way to do it
        $data = $objectManager->createQuery('select u from User\Entity\User u')->getResult() ;
        // the other way to do it
       // $data = $objectManager->getRepository('User\Entity\User')->findAll();
        foreach($data as $key=>$row)
        {
            echo $row->getId()."::".$row->getFullName();
            echo '<br />';
            foreach ($row->getUserMessages() as $message ){
                echo $message->getMessage();
            }
            
        }
        
        //MESSAGES

        echo "<h1>Messages </h1>";
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
       // $objectManager =  $this->getEntityManager();
        // one way to do it
        //$data = $objectManager->createQuery('select u from User\Entity\User u')->getResult() ;
        // the other way to do it
        $data = $objectManager->getRepository('User\Entity\Messages')->findAll();
        foreach($data as $obj)
        {
            echo $obj->getId()."::".$obj->getMessage();
            echo '<br />';
            foreach ($obj->getMessageUsers() as $user ){
                echo $user->getFullName();
            }
            
        }
        
        
        
//        $user = new \User\Entity\User();
//        $user->setFullName('Marco Pivetta');
//
//        $objectManager->persist($user);
//        $objectManager->flush();
//
//        die(var_dump($user->getId()));
        return true ;
    }
}

?>
