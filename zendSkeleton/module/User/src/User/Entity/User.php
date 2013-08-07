<?php
/**
 * Description of User
 *
 * @author mario
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
    private $messages;
    
    public function __construct() {
        $this->messages = new ArrayCollection();
    }
    public function getUserMessages(){
        return $this->messages ; 
    }
    
    public function getId(){
        return $this->id ;
    }
    public function setFullName($fullName){
        $this->fullName = $fullName ; 
    }
    public function getFullName(){
        return $this->fullName ; 
    }

}

?>
