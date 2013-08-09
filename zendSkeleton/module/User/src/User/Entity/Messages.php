<?php

/**
 * Description of Messages
 *
 * @author mario
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
        $this->users = new ArrayCollection();
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
    
    public function setNewMessage(array $data = array()) {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
 
   
}

?>
