<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column]
    private ?int $note;

    #[ORM\Column]
    private ?string $comment;

    #[ORM\Column]
    private ?string $userName;

    #[ORM\Column(nullable: true)]
    private ?int $movieId;

    #[ORM\Column(nullable: true)]
    private ?int $serieId;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct(){}

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

    /**
     * @return int|null
     */
    public function getMovieId(): ?int
    {
        return $this->movieId;
    }

    /**
     * @param int|null $movieId
     */
    public function setMovieId(?int $movieId): void
    {
        $this->movieId = $movieId;
    }

    /**
     * @return int|null
     */
    public function getSerieId(): ?int
    {
        return $this->serieId;
    }

    /**
     * @param int|null $serieId
     */
    public function setSerieId(?int $serieId): void
    {
        $this->serieId = $serieId;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}