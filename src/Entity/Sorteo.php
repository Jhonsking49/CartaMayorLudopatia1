<?php

namespace App\Entity;

use App\Repository\SorteoRepository;
use App\Repository\BoletoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity(repositoryClass: SorteoRepository::class)]
class Sorteo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'sorteo', targetEntity: Boleto::class)]
    private Collection $boletos;

    #[ORM\ManyToOne(inversedBy: 'sorteos')]
    private ?User $ganador = null;

    #[ORM\ManyToOne(inversedBy: 'sorteosCreados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creador = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaINI = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaFIN = null;

    #[ORM\Column]
    private ?int $precioBoleto = null;

    #[ORM\Column]
    private ?int $numerosPosibles = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $state = null;

    public function __construct()
    {
        $this->boletos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Boleto>
     */
    public function getBoletos(): Collection
    {
        return $this->boletos;
    }

    public function addBoleto(Boleto $boleto): static
    {
        if (!$this->boletos->contains($boleto)) {
            $this->boletos->add($boleto);
            $boleto->setSorteo($this);
        }

        return $this;
    }

    public function removeBoleto(Boleto $boleto): static
    {
        if ($this->boletos->removeElement($boleto)) {
            // set the owning side to null (unless already changed)
            if ($boleto->getSorteo() === $this) {
                $boleto->setSorteo(null);
            }
        }

        return $this;
    }

    public function getGanador(): ?User
    {
        return $this->ganador;
    }

    public function setGanador(?User $ganador): static
    {
        $this->ganador = $ganador;

        return $this;
    }

    public function getCreador(): ?User
    {
        return $this->creador;
    }

    public function setCreador(?User $creador): static
    {
        $this->creador = $creador;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaINI(): ?\DateTimeInterface
    {
        return $this->fechaINI;
    }

    public function setFechaINI(\DateTimeInterface $fechaINI): static
    {
        $this->fechaINI = $fechaINI;

        return $this;
    }

    public function getFechaFIN(): ?\DateTimeInterface
    {
        return $this->fechaFIN;
    }

    public function setFechaFIN(\DateTimeInterface $fechaFIN): static
    {
        $this->fechaFIN = $fechaFIN;

        return $this;
    }

    public function getPrecioBoleto(): ?int
    {
        return $this->precioBoleto;
    }

    public function setPrecioBoleto(int $precioBoleto): static
    {
        $this->precioBoleto = $precioBoleto;

        return $this;
    }

    public function getNumerosPosibles(): ?int
    {
        return $this->numerosPosibles;
    }

    public function setNumerosPosibles(int $numerosPosibles): static
    {
        $this->numerosPosibles = $numerosPosibles;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function comprobarFinalizacion($boletoRepository)
    {
        // dump($this->fechaFIN);
        // dump(new DateTime('now'));
        $fechaFinDateTime = $this->fechaFIN instanceof \DateTime ? $this->fechaFIN : new \DateTime($this->fechaFIN);

        if ($this->ganador === null && $fechaFinDateTime < new \DateTime('now')) {
            $boletoGanador = $boletoRepository->findBoletoGanador($this);
    
            if ($boletoGanador !== null) {
                // dd($boletoGanador);
                // die;
                $this->setGanador($boletoGanador->getPropietario());
                return true;
            }else{
                return false;
            }
        }
    }
}
