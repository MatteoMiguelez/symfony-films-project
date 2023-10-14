<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class Review
{
    private ?string $id;

    private ?int $note;

    private ?string $comment;

    private ?Collection $movie;

    private ?Collection $serie;

    private ?string $userName;

    public function __construct()
    {
        $this->movie = new ArrayCollection();
        $this->serie = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getNote(): ?int
    {
        return $this->note;
    }

    /**
     * @param int|null $note
     */
    public function setNote(?int $note): void
    {
        $this->note = $note;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return Collection|null
     */
    public function getMovie(): ?Collection
    {
        return $this->movie;
    }

    /**
     * @param Collection|null $movie
     */
    public function setMovie(?Collection $movie): void
    {
        $this->movie = $movie;
    }

    /**
     * @return Collection|null
     */
    public function getSerie(): ?Collection
    {
        return $this->serie;
    }

    /**
     * @param Collection|null $serie
     */
    public function setSerie(?Collection $serie): void
    {
        $this->serie = $serie;
    }

    /**
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @param string|null $userName
     */
    public function setUserName(?string $userName): void
    {
        $this->userName = $userName;
    }
}