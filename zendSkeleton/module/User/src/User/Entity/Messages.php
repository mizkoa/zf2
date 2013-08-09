<?php

/**
 * Messages: Entity
 * Related to Users by the table User_Message: One message can be related to one or more users. 
 *
 * @author @mrod
 * 08.2013
 * 
 * To create the database from terminaL, using the docblocks specified in each Entity:
 * 
 * ./vendor/bin/doctrine-module orm:validate-schema     <-- checks the schema
 * ./vendor/bin/doctrine-module orm:schema-tool:create  <-- creates the table 
 * ./vendor/bin/doctrine-module orm:schema-tool:update  <-- updates the schema with new changes  (may need to use --force to update the changes in DB 
 * ./vendor/bin/doctrine-module orm:schema-tool:drop --full-database --force   <-- Deletes the whole DB (in the server)
 * 
 */
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/** @ORM\Entity */
class Messages {
    /**    
    * @ORM\Id
    * @ORM\Column(type="integer");
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    /**
    * @ORM\Column(type="string")
    */
    protected $message;
    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="User_Message", 
     *              joinColumns={@ORM\JoinColumn(name="id_message", referencedColumnName = "id")}, 
     *              inverseJoinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName="id")})
     */
    private $users;
    
    public function __construct() {
        $this->users = new ArrayCollection(); // keeps the collection of Users (objects from Users Entity) related with this message (through the User_Message table)
    }
    public function getMessageUsers(){
        return $this->users ; 
    }
    /**
    * Get id
    *
    * @return integer 
    */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set message
     *
     * @param string $message
     * @return Messages
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }
    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * Initialize the whole Entity with the values of each property passed by the param (array) $param
     * @param array $data
     */
    public function setNewMessage(array $data = array()) {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
    /**
     * Associates a user to the message
     * @param \User\Entity\User $user
     */
    public function setNewUser2TheMessage(\User\Entity\User $user){
        $this->users[] = $user ; //adds User to the message
    }
    /**
     * 
     * @param \User\Entity\Messages $user
     */
    public function unsetUserMessage(\User\Entity\User $user){
        $this->users->removeElement($user) ;
    }
    
   
}

?>
