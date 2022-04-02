<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $date;

    #[ORM\Column(type: 'array')]
    private array $articles = [];

    #[ORM\Column(type: 'float')]
    private float $total;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commande')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $idUser;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getArticles(): ?array
    {
        return $this->articles;
    }

    public function setArticles(array $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getIdUser(): ?user
    {
        return $this->idUser;
    }

    public function setIdUser(?user $IdUser): self
    {
        $this->idUser = $IdUser;

        return $this;
    }
}
