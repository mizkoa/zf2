<?php
/**
 * User's entity. 
 * Related to Users by the table User_Message:
 *
 * @author mrod
 * 08.2013
 * 
 * One User can have more than one message. And one message can belong to more than one User ==> ManyToMany
 */
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/** @ORM\Entity */
class User {
     /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $fullName;
    
    /**
     * @ORM\ManyToMany(targetEntity="Messages")
     * @ORM\JoinTable(name="User_Message", 
     *              joinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName = "id")}, 
     *              inverseJoinColumns={@ORM\JoinColumn(name="id_message", referencedColumnName="id")})
     */
    private $messages; // this property will contain the collection of messages (objects from Messages entity) related with the user by the table User_Message
    /**
     * 
     */
    public function __construct() {
        $this->messages = new ArrayCollection();
    }
    /**
     * 
     * @return type
     */
    public function getUserMessages(){
        return $this->messages ; 
    }
    /**
     * 
     * @return type
     */
    public function getId(){
        return $this->id ;
    }
    /**
     * 
     * @param type $fullName
     */
    public function setFullName($fullName){
        $this->fullName = $fullName ; 
    }
    /**
     * 
     * @return type
     */
    public function getFullName(){
        return $this->fullName ; 
    }
    /**
     * 
     * @param array $data
     */
    public function setNewUser(array $data = array()) {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
    /**
     * 
     * @param \User\Entity\Messages $message
     */
    public function setNewMessage2TheUser(\User\Entity\Messages $message){
        $this->messages[] = $message ; //adds message to the User
    }
    /**
     * 
     * @param \User\Entity\Messages $message
     */
    public function unsetMessageUser(\User\Entity\Messages $message){
        $this->messages->removeElement($message) ; //get the fuck out 
    }
    

}

?>
