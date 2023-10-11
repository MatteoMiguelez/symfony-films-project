<?php

namespace App\Entity;
use Doctrine\Common\Collections\Collection;

class Theme
{
    private ?int $id;

    private ?string $name;

    private Collection $movies;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    /**
     * @param Collection $movies
     */
    public function setMovies(Collection $movies): void
    {
        $this->movies = $movies;
    }

    public function addMovie(Movie $movie): void
    {
        if(!$this->movies->contains($movie)){
            $this->movies->add($movie);
        }
    }

    public function removeMovie(Movie $movie): void
    {
        if($this->movies->contains($movie)){
            $this->movies->removeElement($movie);
            $movie->removeTheme($this);
        }
    }
}