<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Entity\User as userEntity ;
use User\Entity\Messages as messageEntity ;


class IndexController extends AbstractActionController
{
    protected $em ; // Doctrine\ORM\EntityManager
    
    public function getEntityManager(){
        if($this->em === null){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); // same thing as $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }

    return $this->em  ;
    }
    
    public function indexAction() //list users and messages
    {
        // USERS
        echo "  > listing users....</br>";        
        $usersObj = $this->getEntityManager()->createQuery('select u from User\Entity\User u')->getResult() ; // one way to do it: executing the query
        foreach($usersObj as $userObj){ // go trough all collection of users and print their messages            
            echo $userObj->getId()."->".$userObj->getFullName()." <a href='".$this->url()->fromRoute('user_del', array('id'=>$userObj->getId()))."'>Delete</a>";
            echo '<br/>listing messages of '.$userObj->getFullName()."...<br/>";
            if (count($userObj->getUserMessages())>0){
                foreach ($userObj->getUserMessages() as $message ){ // go through all collection of messages and print them out
                    echo "==> ".$message->getMessage()."<br/>";
                }
            } else echo ".....".$userObj->getFullName()." has no messages.<br/>" ; 
            echo "\\\----------------------------------</br>" ;
        }
        //MESSAGES
        echo "/***********************************************</br>";
        echo " > listing messages..........</br>";
        $messagesObj = $this->getEntityManager()->getRepository('User\Entity\Messages')->findAll(); // different way to do it (check out upper users object) get messages collection
        foreach($messagesObj as $messageObj){
            echo $messageObj->getId()."->".$messageObj->getMessage()."...<br/>";
            echo "listing users attached to this message...<br/>";
            foreach ($messageObj->getMessageUsers() as $user ){
                echo "==> ". $user->getFullName()."<br/>";
            }
        }
        echo "<a href='".$this->url()->fromRoute('user_add')."'>Add</a>";
        return true ;
    }
    public function addAction(){
       $em = $this->getEntityManager() ;
       //USER
       
       $user = new userEntity() ;
       $user->setNewUser(array('fullName'=>$this->getRandomKindaWord())) ;
       
       $em->persist($user);
       $em->flush();
       echo $user->getFullName()." has been added"  ;
      
       
       // MESSAGE
       $message = new messageEntity();
       $message->setNewMessage(array('message'=>$this->getRandomKindaMessage(rand(5,10),rand(8,10)))) ;
       
       $em->persist($message); //<-- INSERT
       $em->flush();
       echo $message->getMessage()." has been added"  ;
       
       
       //USER - MESSAGE
       $user->setNewMessage2TheUser($message) ; 
       $em->merge($user); //<-- update user with the new message
       $em->flush();
       
      
       echo "<a href='".$this->url()->fromRoute('user')."'><< back to list</a>";
       return true ; 
    }
    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id', 0); // <-- get ID
        $em = $this->getEntityManager();
        $user = $em->getRepository('User\Entity\User')->findOneBy(array('id'=>$id)); // also like $user = $em->find('User\Entity\User',2);
        if ($user===null) throw new \Exception("A guy already gone is trying to be deleted!"); 
        echo "Deleting ".$user->getFullName()."......";
        $em->remove($user) ; 
        $em->flush();
        echo "</br>Delete succeded";
        echo "<a href='".$this->url()->fromRoute('user')."'><< back to list</a>";
        return true ; 
    }
    
    public function getRandomKindaWord($min=3,$max=9){
        $vocals = "aeiou" ; 
        $konsonant ="bcdfghjklmnpqrstvwxyt";
        $name='';
        $toggle = false ;
        for ($i=1;$i<=rand($min,$max);$i++){
            $name.=($toggle)?$konsonant[rand(0, strlen($konsonant)-1)]:$vocals[rand(0, strlen($vocals)-1)];  ;
            $toggle=!$toggle;
        }
        return ucfirst($name) ; 
    }
    public function getRandomKindaMessage($numWords=10,$maxWordsLetters=8){
        $message='';
        for ($i=0;$i<$numWords;$i++){
            $message.=$this->getRandomKindaWord(1,rand(1,$maxWordsLetters))." ";
        }
        return ucfirst(rtrim($message)) ;
    }
    
}

?>
