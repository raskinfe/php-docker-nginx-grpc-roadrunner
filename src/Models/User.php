<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity]
#[ORM\Table(name:"users")]
class User {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", unique: true)]
    private $username;
    #[ORM\Column(type:"string")]
    private $password;

    #[ORM\Column(type:"string", unique: true)]    
    private $email;

    #[ORM\Column(type:"string")]
    private $name;

    #[OneToMany(mappedBy:"", targetEntity: Note::class)]
    private Collection $notes;

    public function __construct() {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int 
    {
        return $this->id;
     }
    public function getUsername(): ?string 
    {
        return $this->username;
     }

     public function getName(): ?string 
     {
        return $this->name;
     }

     public function getPassword(): ?string 
     {
        return $this->password;
     }

     public function getEmail(): ?string 
     {
        return $this->email;
     }
    public function setName(?string $name): void 
    { 
        $this->name = $name;
    }

    public function setEmail(?string $email): void 
    { 
        $this->email = $email;
    }

    public function setUsername(?string $username): void 
    { 
        $this->username = $username;
    }
    public function setPassword(?string $password): void 
    { 
        $this->password = $password;
    }

    public function addNote(Note $note): void 
    { 
        $this->notes[] = $note;
    }

    public function getNotes(): array 
    {
        return $this->notes->toArray();
    }
}