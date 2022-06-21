<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $caption;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total_like;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total_comment;

    /**
     * @ORM\Column(type="date")
     */
    private $upload_time;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user_post")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): self
    {
        $this->caption = $caption;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTotalLike(): ?int
    {
        return $this->total_like;
    }

    public function setTotalLike(?int $total_like): self
    {
        $this->total_like = $total_like;

        return $this;
    }

    public function getTotalComment(): ?int
    {
        return $this->total_comment;
    }

    public function setTotalComment(?int $total_comment): self
    {
        $this->total_comment = $total_comment;

        return $this;
    }

    public function getUploadTime(): ?\DateTimeInterface
    {
        return $this->upload_time;
    }

    public function setUploadTime(\DateTimeInterface $upload_time): self
    {
        $this->upload_time = $upload_time;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
