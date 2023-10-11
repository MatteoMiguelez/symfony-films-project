<?php

namespace App\Entity;

use App\Repository\FavouriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavouriteRepository::class)]
class Favourite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $filmId = null;

    #[ORM\Column(nullable: true)]
    private ?int $serieId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilmId(): ?int
    {
        return $this->filmId;
    }

    public function setFilmId(int $filmId): static
    {
        $this->filmId = $filmId;

        return $this;
    }

    public function getSerieId(): ?int
    {
        return $this->serieId;
    }

    public function setSerieId(?int $serieId): static
    {
        $this->serieId = $serieId;

        return $this;
    }
}
