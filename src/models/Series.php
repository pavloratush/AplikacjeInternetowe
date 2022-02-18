<?php


class Series
{
    private $title;
    private $likes;
    private $dislikes;
    private $genre;
    private $review;
    private $creationDate;
    private $image;
    private $id;


    public function __construct($title, $likes, $dislikes, $genre, $creationDate, $image,$id=null)
    {
        $this->title = $title;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->genre = $genre;
        $this->creationDate = $creationDate;
        $this->image = $image;
        $this->id = $id;
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function setTitle($title): void
    {
        $this->title = $title;
    }


    public function getLikes(): int
    {
        return $this->likes;
    }


    public function setLikes($likes): void
    {
        $this->likes = $likes;
    }


    public function getDislikes(): int
    {
        return $this->dislikes;
    }


    public function setDislikes($dislikes): void
    {
        $this->dislikes = $dislikes;
    }


    public function getGenre(): string
    {
        return $this->genre;
    }


    public function setGenre($genre): void
    {
        $this->genre = $genre;
    }


    public function getReview(): string
    {
        return $this->review;
    }


    public function setReview($review): void
    {
        $this->review = $review;
    }


    public function getCreationDate(): int
    {
        return $this->creationDate;
    }


    public function setCreationDate($creationDate): void
    {
        $this->creationDate = $creationDate;
    }


    public function getImage(): string
    {
        return $this->image;
    }


    public function setImage($image): void
    {
        $this->image = $image;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function setId(?mixed $id): void
    {
        $this->id = $id;
    }




}