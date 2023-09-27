<?php

namespace App\Entity;

use Cassandra\Collection;
use Symfony\Component\Validator\Constraints\DateTime;

class Serie
{
    private ?int $id;

    private ?string $nom;

    private ?string $seasonNb;

    private ?string $language;

    private ?string $episodeNb;

    private ?DateTime $releaseDate;

    private ?float $ratingNb;

    private ?string $director;

    private ?Collection $themes;

    private ?string $picturePath;

    private ?string $description;

    private ?string $originCountry;

    private ?Collection $note;

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
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string|null
     */
    public function getSeasonNb(): ?string
    {
        return $this->seasonNb;
    }

    /**
     * @param string|null $seasonNb
     */
    public function setSeasonNb(?string $seasonNb): void
    {
        $this->seasonNb = $seasonNb;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     */
    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string|null
     */
    public function getEpisodeNb(): ?string
    {
        return $this->episodeNb;
    }

    /**
     * @param string|null $episodeNb
     */
    public function setEpisodeNb(?string $episodeNb): void
    {
        $this->episodeNb = $episodeNb;
    }

    /**
     * @return DateTime|null
     */
    public function getReleaseDate(): ?DateTime
    {
        return $this->releaseDate;
    }

    /**
     * @param DateTime|null $releaseDate
     */
    public function setReleaseDate(?DateTime $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return float|null
     */
    public function getRatingNb(): ?float
    {
        return $this->ratingNb;
    }

    /**
     * @param float|null $ratingNb
     */
    public function setRatingNb(?float $ratingNb): void
    {
        $this->ratingNb = $ratingNb;
    }

    /**
     * @return string|null
     */
    public function getDirector(): ?string
    {
        return $this->director;
    }

    /**
     * @param string|null $director
     */
    public function setDirector(?string $director): void
    {
        $this->director = $director;
    }

    /**
     * @return Collection
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    /**
     * @param Collection $themes
     */
    public function setThemes(Collection $themes): void
    {
        $this->themes = $themes;
    }

    /**
     * @return string|null
     */
    public function getPicturePath(): ?string
    {
        return $this->picturePath;
    }

    /**
     * @param string|null $picturePath
     */
    public function setPicturePath(?string $picturePath): void
    {
        $this->picturePath = $picturePath;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getOriginCountry(): ?string
    {
        return $this->originCountry;
    }

    /**
     * @param string|null $originCountry
     */
    public function setOriginCountry(?string $originCountry): void
    {
        $this->originCountry = $originCountry;
    }

    /**
     * @return Collection|null
     */
    public function getNote(): ?Collection
    {
        return $this->note;
    }

    /**
     * @param Collection|null $note
     */
    public function setNote(?Collection $note): void
    {
        $this->note = $note;
    }
}