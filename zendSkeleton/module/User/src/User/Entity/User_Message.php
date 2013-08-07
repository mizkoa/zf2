<?php
/**
 * Description of User
 *
 * @author mario
 * 
 * ./vendor/bin/doctrine-module orm:schema-tool:update --force
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
    
    
    public function getId(){
        return $this->id ;
    }
    
    public function getId_user(){
         return $this->id_user ;
    }
    public function getId_message(){
        return $this->id_message ; 
    }
    public function setId_user($idUser){
        $this->id_user = $idUser ;
    }
    public function setId_mesagge($idMessage){
        $this->id_message = $idMessage ; 
    }

}

?>
