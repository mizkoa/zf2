<?php
namespace DoctrineExp\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class User {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $artist;

    /** @ORM\Column(type="string") */
    protected $title;
    
    // getters/setters
}

?>
