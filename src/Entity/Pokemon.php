<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(length: 3)]
    private ?string $pokedexNumber = null;

    #[ORM\Column(length: 20)]
    private ?string $primaryType = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $secondaryType = null;

    #[ORM\ManyToMany(targetEntity: Team::class, mappedBy: 'pokemon')]
    private Collection $teams;

    #[ORM\Column]
    private ?bool $favorite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPokedexNumber(): ?string
    {
        return $this->pokedexNumber;
    }

    public function setPokedexNumber(string $pokedexNumber): static
    {
        $this->pokedexNumber = $pokedexNumber;

        return $this;
    }

    public function getPrimaryType(): ?string
    {
        return $this->primaryType;
    }

    public function setPrimaryType(string $primaryType): static
    {
        $this->primaryType = $primaryType;

        return $this;
    }

    public function getSecondaryType(): ?string
    {
        return $this->secondaryType;
    }

    public function setSecondaryType(?string $secondaryType): static
    {
        $this->secondaryType = $secondaryType;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->addPokemon($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            $team->removePokemon($this);
        }

        return $this;
    }

    public function isFavorite(): ?bool
    {
        return $this->favorite;
    }

    public function setFavorite(bool $favorite): static
    {
        $this->favorite = $favorite;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
