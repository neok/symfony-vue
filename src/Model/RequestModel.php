<?php

namespace App\Model;

class RequestModel
{
    /** @var string */
    protected $title;
    /** @var string */
    protected $genre;
    /**
     * @var \DateTime|null
     */
    protected $weekStart;

    /**
     * @var \DateTime|null
     */
    protected $weekEnd;

    public function __construct(?string $title, ?string $genre, ?\DateTime $weekStart, ?\DateTime $weekEnd)
    {
        $this->title     = $title;
        $this->genre     = $genre;
        $this->weekStart = $weekStart;
        $this->weekEnd   = $weekEnd;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function getWeekStart(): ?\DateTime
    {
        return $this->weekStart;
    }

    public function setWeekStart(?\DateTime $weekStart): self
    {
        $this->weekStart = $weekStart;

        return $this;
    }

    public function getWeekEnd(): ?\DateTime
    {
        return $this->weekEnd;
    }

    public function setWeekEnd(?\DateTime $weekEnd): self
    {
        $this->weekEnd = $weekEnd;

        return $this;
    }
}
