<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime;

class Serie
{
    private ?int $id;

    private ?string $title;

    private ?string $picturePath;

    private ?string $description;

    private ?string $language;

    private ?DateTime $releaseDate;

    private ?float $rating;

    private ?string $director;

    private Collection $themes;

    private Collection $reviews;

    private Collection $actors;

    private Collection $watchProviders;

    private ?bool $isAdult;

    private ?bool $isFavourite;

    private ?string $seasonNb;

    private ?string $episodeNb;

    private ?string $originCountry;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->watchProviders = new ArrayCollection();
    }

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
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
    public function getRating(): ?float
    {
        return $this->rating;
    }

    /**
     * @param float|null $rating
     */
    public function setRating(?float $rating): void
    {
        $this->rating = $rating;
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
     * @return bool|null
     */
    public function getIsAdult(): ?bool
    {
        return $this->isAdult;
    }

    /**
     * @param bool|null $isAdult
     */
    public function setIsAdult(?bool $isAdult): void
    {
        $this->isAdult = $isAdult;
    }

    /**
     * @return bool|null
     */
    public function getIsFavourite(): ?bool
    {
        return $this->isFavourite;
    }

    /**
     * @param bool|null $isFavourite
     */
    public function setIsFavourite(?bool $isFavourite): void
    {
        $this->isFavourite = $isFavourite;
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
     * @return Collection
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    /**
     * @param Collection $reviews
     */
    public function setReviews(Collection $reviews): void
    {
        $this->reviews = $reviews;
    }

    /**
     * @return Collection
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    /**
     * @param Collection $actors
     */
    public function setActors(Collection $actors): void
    {
        $this->actors = $actors;
    }

    /**
     * @return Collection
     */
    public function getWatchProviders(): Collection
    {
        return $this->watchProviders;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actors->contains($actor)){
            $this->actors->add($actor);
        }

        return $this;
    }

    public function addTheme(Theme $theme): void
    {
        if(!$this->themes->contains($theme)){
            $this->themes->add($theme);
        }
    }

    public function addReview(Review $review): void
    {
        if(!$this->reviews->contains($review)){
            $this->reviews->add($review);
        }
    }

    public function addWatchProvider(WatchProvider $watchProvider): void
    {
        if(!$this->watchProviders->contains($watchProvider)){
            $this->watchProviders->add($watchProvider);
        }
    }
}