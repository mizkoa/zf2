<?php
/**
 * Two Entities, User and Messages and one relation between them: User_Messages. One User may have none, one or more messages and one message may belong to none, one or more users.
 * Relationship between these tables are described using doctrine's Docblock in User and Messages (User_Messages DOESN'T need to have docblocks. 
 * Two dummy functions to create random 'kinda'names and 'kinda'random messages - non sense - 
 * 
 * This controller is just a very simple example of how to do, having two entities related (many to many), inserts, updates and deletes in each one of the entities.
 * - Add/delete random User name
 * - Add/delete random message
 * - Add user and message and relate them (associate on message to a User)
 * - Add message and user and relate them (associate one User to a message)
 * 
 * @mrod
 * 08.2013
 * 
 * 
 */
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Entity\User as userEntity ;
use User\Entity\Messages as messageEntity ;

class IndexController extends AbstractActionController
{
    protected $em ; // Doctrine\ORM\EntityManager
    
    /**
     * 
     * @return type
     */
    public function getEntityManager(){
        if($this->em === null){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); // same thing as $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default'); orm_default defined in autoload/global.php and autoload/local.php
        }

        return $this->em  ;
    }
    /**
     * 
     * @return boolean
     */
    public function indexAction() //list users and messages
    {      
        echo "<a href='".$this->url()->fromRoute('users')."'>View Users</a>"; //<-- the way to access to a route defined in module.config.php
        echo "<br/><a href='".$this->url()->fromRoute('messages')."'>View Messages</a>"; 
        echo "<br/><a href='".$this->url()->fromRoute('messages/message_add')."'>Add Message</a>"; //<-- the way to access to child_routes defined in module.config.php
        echo "<br/><a href='".$this->url()->fromRoute('user_add')."'>Add User</a>";
        echo "<br/><a href='".$this->url()->fromRoute('message_user')."'>Add Message to User</a>";
        echo "<br/><a href='".$this->url()->fromRoute('user_message')."'>Add User to Message</a>";
        return true ;
    }
    public function showUsersAction(){
        // List all the users from the DB
        echo "  > listing users....</br>";        
        $usersObj = $this->getEntityManager()->createQuery('select u from User\Entity\User u')->getResult() ; // one way to do it: executing the query
        foreach($usersObj as $userObj){ // go trough all collection of users and print their messages            
            echo $userObj->getId()."->".$userObj->getFullName()." <a href='".$this->url()->fromRoute('user_del', array('id'=>$userObj->getId()))."'>Delete</a>";
            echo '<br/>listing messages of '.$userObj->getFullName()."...<br/>";
            if (count($userObj->getUserMessages())>0){
                foreach ($userObj->getUserMessages() as $message ){ // go through all collection of messages and print them out
                    echo "==> ".$message->getMessage()."&nbsp;<a href='".$this->url()->fromRoute('user_del_mess', array('id_user'=>$userObj->getId(),'id_message'=>$message->getId()))."'><< unset message</a><br/>";
                }
            } else echo ".....".$userObj->getFullName()." has no messages.<br/>" ; 
            echo "\\\----------------------------------</br>" ;
        }
        echo "<a href='".$this->url()->fromRoute('home')."'><< back to options</a>"; // 'home'is defined in the Application/module.config
        return true ; 
    }
    /** messages **/
    public function showMessagesAction(){
         //List all the messages from the DB
        echo "/***********************************************</br>";
        echo " > listing messages..........</br>";
        $messagesObj = $this->getEntityManager()->getRepository('User\Entity\Messages')->findAll(); // different way to do it (check out upper users object) get messages collection
        foreach($messagesObj as $messageObj){
            echo $messageObj->getId()."->".$messageObj->getMessage()."... <a href='".$this->url()->fromRoute('messages/message_delete', array('id'=>$messageObj->getId()))."'><< Delete</a><br/>";
            echo "listing users attached to this message...<br/>";
            foreach ($messageObj->getMessageUsers() as $user ){
                echo "==> ". $user->getFullName()."&nbsp;<a href='".$this->url()->fromRoute('messages/mess_del_user', array('id_user'=>$user->getId(),'id_message'=>$messageObj->getId()))."'><< unset user</a><br/>";
            }
        } 
        echo "<a href='".$this->url()->fromRoute('home')."'><< back to options</a>"; // 'home'is defined in the Application/module.config
        return true ; 
    }
    public function deleteMessagesAction(){
        $id = (int) $this->params()->fromRoute('id', 0); // <-- get ID
        $em = $this->getEntityManager();
        $msg = $em->getRepository('User\Entity\Messages')->findOneBy(array('id'=>$id)); // 
        if ($msg===null) throw new \Exception("Trying to delete a message that not exists anymore!"); 
        echo "Deleting ".$msg->getMessage()."......";
        $em->remove($msg) ; 
        $em->flush();
        echo "</br>Delete succeded";
        echo "<a href='".$this->url()->fromRoute('messages')."'><< back to list</a>";
        return true ; 
        
    }
    
    public function addMessagesAction(){
       $em = $this->getEntityManager();
       $message = new messageEntity();
       $message->setNewMessage(array('message'=>$this->getRandomKindaMessage(rand(5,10),rand(8,10)))) ;
       
       $em->persist($message); //<-- INSERT
       $em->flush();
       echo $message->getMessage()." has been added"  ;
       echo "<a href='".$this->url()->fromRoute('messages')."'><< back to list</a>";
       
       return true ; 
        
    }
    public function addMessageUserAction(){
        
       $em = $this->getEntityManager() ;
       // Create User
       $user = new userEntity() ;
       $user->setNewUser(array('fullName'=>$this->getRandomKindaWord())) ;
       //insert new user
       $em->persist($user);
       $em->flush();
       // Create Message
       $message = new messageEntity();
       $message->setNewMessage(array('message'=>$this->getRandomKindaMessage(rand(5,10),rand(8,10)))) ;
       //insert new message
       $em->persist($message); 
       $em->flush();         
       //assign user to message
       $user->setNewMessage2TheUser($message) ; 
       $em->merge($user); //<-- update user with the new message
       $em->flush();
       echo "The message ".$message->getMessage()." has been asigned to user ".$user->getFullName() ; 
       echo "<a href='".$this->url()->fromRoute('home')."'><< back to options</a>";
       
       return true ; 
    }
    
   
    // asign user to a message - opossite as  public function addMessageUserAction()
     public function addUserMessageAction(){
       $em = $this->getEntityManager() ;
       // Create Message
       $message = new messageEntity();
       $message->setNewMessage(array('message'=>$this->getRandomKindaMessage(rand(5,10),rand(8,10)))) ;
       //insert new message
       $em->persist($message); 
       $em->flush();               
        // Create User
       $user = new userEntity() ;
       $user->setNewUser(array('fullName'=>$this->getRandomKindaWord())) ;
       //insert new user
       $em->persist($user);
       $em->flush();
      
       //assign user to message
       $message->setNewUser2TheMessage($user) ; 
       $em->merge($message); //<-- update user with the new message
       $em->flush();
       echo "The user ".$user->getFullName()." has been asigned to the message ".$message->getMessage() ;
       echo "<a href='".$this->url()->fromRoute('home')."'><< back to options</a>";
       
       return true ; 
    }
    
    
    
    public function addUserAction(){
        // Add a random user kinda name
       $em = $this->getEntityManager() ;
       
       $user = new userEntity() ;
       $user->setNewUser(array('fullName'=>$this->getRandomKindaWord())) ;
       
       $em->persist($user);
       $em->flush();
       echo $user->getFullName()." has been added"  ;
   
       echo "<a href='".$this->url()->fromRoute('users')."'><< back to list</a>";
       return true ; 
    }
    public function deleteUserAction(){
        $id = (int) $this->params()->fromRoute('id', 0); // <-- get ID
        $em = $this->getEntityManager();
        $user = $em->getRepository('User\Entity\User')->findOneBy(array('id'=>$id)); // also like $user = $em->find('User\Entity\User',2);
        if ($user===null) throw new \Exception("A guy already gone is trying to be deleted!"); 
        echo "Deleting ".$user->getFullName()."......";
        $em->remove($user) ; 
        $em->flush();
        echo "</br>Delete succeded";
        echo "<a href='".$this->url()->fromRoute('users')."'><< back to list</a>";
        return true ; 
    }
    /**
     * Unset a message related with one user. DOES NOT removes the message (Messages entity) but its association with User (removes entry user-message in table Users_messages)
     * 
     * @return boolean
     * @throws \Exception
     */
     
    public function disassociateMessageAction(){
        $em = $this->getEntityManager();
        $id_user = (int) $this->params()->fromRoute('id_user', 0);
        $id_message = (int) $this->params()->fromRoute('id_message', 0); 
        $user = $em->getRepository('User\Entity\User')->findOneBy(array('id'=>$id_user));
        if ($user===null) throw new \Exception("Trying to access a user that does not exists!"); 
        $message = $em->getRepository('User\Entity\Messages')->findOneBy(array('id'=>$id_message));
        if ($message===null) throw new \Exception("Trying to access a message that does not exists!"); 
        $user->unsetMessageUser($message); 
        $em->merge($user); //<-- save changes
        $em->flush();
        echo "The message ".$message->getMessage()." has been unset correctly " ;
        echo "<a href='".$this->url()->fromRoute('users')."'><< back to users</a>";
        return true ;  
    }
    /**
     * Unset a user related with one message. DOES NOT removes the user (User entity) but its association with the message (removes entry user-message in table Users_messages)
     * 
     * @return boolean
     * @throws \Exception
     */
     
    public function disassociateUserAction(){
        $em = $this->getEntityManager();
        $id_user = (int) $this->params()->fromRoute('id_user', 0);
        $id_message = (int) $this->params()->fromRoute('id_message', 0); 
        $user = $em->getRepository('User\Entity\User')->findOneBy(array('id'=>$id_user));
        if ($user===null) throw new \Exception("Trying to access a user that does not exists!"); 
        $message = $em->getRepository('User\Entity\Messages')->findOneBy(array('id'=>$id_message));
        if ($message===null) throw new \Exception("Trying to access a message that does not exists!"); 
      
        
        $message->unsetUserMessage($user);
        $em->merge($message); //<-- save changes
        $em->flush();
        echo "The user ".$user->getFullName()." has been unset correctly " ;
        echo "<a href='".$this->url()->fromRoute('messages')."'><< back to messages</a>";
        return true ;  
    }
    /**
     * Dummy functions
     * 
     * @param type $min
     * @param type $max
     * @return type
     */
    
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
