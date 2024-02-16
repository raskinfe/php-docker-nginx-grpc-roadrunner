<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name:"notes")]
class Note {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;
    #[ORM\Column(type:"string")]
    private $content;

    #[ORM\Column(type:"datetime")]
    private $date;

    #[ManyToOne(targetEntity: User::class, inversedBy:"id")]
    private User $author;

    public function getId(): ?int { 
        return $this->id;
    }


    public function setContent(?string $content): Note {
        $this->content = $content;
        return $this;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function setDate(?\DateTime $date): Note {
        $this->date = $date;
        return $this;
    }

    public function getDate(): ?\DateTime {
        return $this->date;
    }

    public function setAuthor(?User $author): Note {
        $author->addNote($this);
        $this->author = $author;
        return $this;
    }

    public function getAuthor(): ?User {
        return $this->author;
    }
    
}