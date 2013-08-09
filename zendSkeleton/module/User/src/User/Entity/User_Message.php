<?php
/**
 * User_Message
 * Table which relates Users and Messages - see the these two entities to check relations between them
 *
 * @author mrod
 * 08.2013
 * 
 * 
 */
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class User_Message {
     /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    /**
    * @ORM\Column(type="integer");
    */
    protected $id_user;
    /**
    * @ORM\Column(type="integer");
    */    
    protected $id_message;
    
   /**
    * 
    * @return int
    */ 
    public function getId(){
        return $this->id ;
    }
    /**
     * 
     * @return int
     */
    public function getId_user(){
         return $this->id_user ;
    }
    /**
     * 
     * @return int
     */
    public function getId_message(){
        return $this->id_message ; 
    }
    /**
     * 
     * @param int $idUser
     */
    public function setId_user($idUser){
        $this->id_user = $idUser ;
    }
    /**
     * 
     * @param string $idMessage
     */
    public function setId_mesagge($idMessage){
        $this->id_message = $idMessage ; 
    }

}

?>
