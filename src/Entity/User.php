<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'propietario', targetEntity: Boleto::class)]
    private Collection $boletos;

    #[ORM\OneToMany(mappedBy: 'ganador', targetEntity: Sorteo::class)]
    private Collection $sorteos;

    #[ORM\OneToMany(mappedBy: 'creador', targetEntity: Sorteo::class)]
    private Collection $sorteosCreados;

    #[ORM\Column]
    private ?int $saldo = null;

    public function __construct()
    {
        $this->boletos = new ArrayCollection();
        $this->sorteos = new ArrayCollection();
        $this->sorteosCreados = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $boleto->setPropietario($this);
        }

        return $this;
    }

    public function removeBoleto(Boleto $boleto): static
    {
        if ($this->boletos->removeElement($boleto)) {
            // set the owning side to null (unless already changed)
            if ($boleto->getPropietario() === $this) {
                $boleto->setPropietario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sorteo>
     */
    public function getSorteos(): Collection
    {
        return $this->sorteos;
    }

    public function addSorteo(Sorteo $sorteo): static
    {
        if (!$this->sorteos->contains($sorteo)) {
            $this->sorteos->add($sorteo);
            $sorteo->setGanador($this);
        }

        return $this;
    }

    public function removeSorteo(Sorteo $sorteo): static
    {
        if ($this->sorteos->removeElement($sorteo)) {
            // set the owning side to null (unless already changed)
            if ($sorteo->getGanador() === $this) {
                $sorteo->setGanador(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sorteo>
     */
    public function getSorteosCreados(): Collection
    {
        return $this->sorteosCreados;
    }

    public function addSorteosCreado(Sorteo $sorteosCreado): static
    {
        if (!$this->sorteosCreados->contains($sorteosCreado)) {
            $this->sorteosCreados->add($sorteosCreado);
            $sorteosCreado->setCreador($this);
        }

        return $this;
    }

    public function removeSorteosCreado(Sorteo $sorteosCreado): static
    {
        if ($this->sorteosCreados->removeElement($sorteosCreado)) {
            // set the owning side to null (unless already changed)
            if ($sorteosCreado->getCreador() === $this) {
                $sorteosCreado->setCreador(null);
            }
        }

        return $this;
    }

    public function getSaldo(): ?int
    {
        return $this->saldo;
    }

    public function setSaldo(int $saldo): static
    {

        $this->saldo = $this->saldo + $saldo;

        return $this;
    }
    
    public function removeSaldo(int $saldo): static
    {
        $this->saldo = $this->saldo - $saldo;
    
        return $this;
    }
}
