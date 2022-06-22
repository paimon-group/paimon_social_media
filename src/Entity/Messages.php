<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessagesRepository::class)
 */
class Messages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $chat_message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $seen;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user_messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $from_user;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="to_user_message")
     * @ORM\JoinColumn(nullable=false)
     */
    private $to_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChatMessage(): ?string
    {
        return $this->chat_message;
    }

    public function setChatMessage(string $chat_message): self
    {
        $this->chat_message = $chat_message;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getSeen(): ?string
    {
        return $this->seen;
    }

    public function setSeen(string $seen): self
    {
        $this->seen = $seen;

        return $this;
    }

    public function getFromUser(): ?User
    {
        return $this->from_user;
    }

    public function setFromUser(?User $from_user): self
    {
        $this->from_user = $from_user;

        return $this;
    }

    public function getToUser(): ?User
    {
        return $this->to_user;
    }

    public function setToUser(?User $to_user): self
    {
        $this->to_user = $to_user;

        return $this;
    }
}
