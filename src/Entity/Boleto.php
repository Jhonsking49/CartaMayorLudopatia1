<?php

namespace App\Entity;

use App\Repository\BoletoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoletoRepository::class)]
class Boleto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\ManyToOne(inversedBy: 'boletos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $propietario = null;

    #[ORM\ManyToOne(inversedBy: 'boletos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sorteo $sorteo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPropietario(): ?User
    {
        return $this->propietario;
    }

    public function setPropietario(?User $propietario): static
    {
        $this->propietario = $propietario;

        return $this;
    }

    public function getSorteo(): ?Sorteo
    {
        return $this->sorteo;
    }

    public function setSorteo(?Sorteo $sorteo): static
    {
        $this->sorteo = $sorteo;

        return $this;
    }
}
