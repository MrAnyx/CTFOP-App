<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Riddle::class, inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private Riddle $riddle;

    #[ORM\Column(type: 'datetime_immutable')]
    #[ORM\JoinColumn(nullable: false)]
    private \DateTimeImmutable $solvedAt;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $score;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getRiddle(): Riddle
    {
        return $this->riddle;
    }

    public function setRiddle(Riddle $riddle): self
    {
        $this->riddle = $riddle;
        return $this;
    }

    public function getSolvedAt(): \DateTimeImmutable
    {
        return $this->solvedAt;
    }

    public function setSolvedAt(\DateTimeImmutable $solvedAt): self
    {
        $this->solvedAt = $solvedAt;
        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
