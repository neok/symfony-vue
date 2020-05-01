<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank();
     * @Assert\Length(max=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank();
     * @Assert\Length(max=100)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url();
     */
    private $imageSrc;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Showtime", mappedBy="movie", cascade={"all"})
     * @Assert\Valid
     */
    private $showtimes;

    public function __construct()
    {
        $this->showtimes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getImageSrc(): ?string
    {
        return $this->imageSrc;
    }

    public function setImageSrc(string $imageSrc): self
    {
        $this->imageSrc = $imageSrc;

        return $this;
    }

    /**
     * @return Collection|Showtime[]
     */
    public function getShowtimes(): Collection
    {
        return $this->showtimes;
    }

    public function addShowtime(Showtime $showtime): self
    {
        if (!$this->showtimes->contains($showtime)) {
            $this->showtimes[] = $showtime;
            $showtime->setMovie($this);
        }

        return $this;
    }

    public function removeShowtime(Showtime $showtime): self
    {
        if ($this->showtimes->contains($showtime)) {
            $this->showtimes->removeElement($showtime);
            // set the owning side to null (unless already changed)
            if ($showtime->getMovie() === $this) {
                $showtime->setMovie(null);
            }
        }

        return $this;
    }
}
