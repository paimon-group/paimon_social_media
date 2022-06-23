<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
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
    private $reason;

    /**
     * @ORM\Column(type="datetime")
     */
    private $report_time;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user_send_report")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_send_report;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user_reported")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_reported;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="post_report")
     */
    private $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getReportTime(): ?\DateTimeInterface
    {
        return $this->report_time;
    }

    public function setReportTime(\DateTimeInterface $report_time): self
    {
        $this->report_time = $report_time;

        return $this;
    }

    public function getUserSendReport(): ?User
    {
        return $this->user_send_report;
    }

    public function setUserSendReport(?User $user_send_report): self
    {
        $this->user_send_report = $user_send_report;

        return $this;
    }

    public function getUserReported(): ?User
    {
        return $this->user_reported;
    }

    public function setUserReported(?User $user_reported): self
    {
        $this->user_reported = $user_reported;

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
