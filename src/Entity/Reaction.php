<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

 

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user_reaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="Post_Reaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}
