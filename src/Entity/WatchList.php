<?php

namespace App\Entity;

use App\Repository\WatchListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchListRepository::class)]
class WatchList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'watchLists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Program::class)]
    private Collection $programs;

    #[ORM\Column]
    private ?bool $seen = null;

    #[ORM\Column]
    private ?bool $liked = null;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
    }


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
        // remove the current watchlist from the old user
        if ($this->user !== null && $this->user->getWatchLists()->contains($this)) {
            $this->user->getWatchLists()->removeElement($this);
        }

        // set the new user
        $this->user = $user;

        // add this watchlist to the new user's watchlists
        if ($user !== null && !$user->getWatchLists()->contains($this)) {
            $user->getWatchLists()->add($this);
        }

        return $this;
    }

    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        $this->programs->removeElement($program);

        return $this;
    }

    public function isSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): static
    {
        $this->seen = $seen;

        return $this;
    }

    public function isLiked(): ?bool
    {
        return $this->liked;
    }

    public function setLiked(bool $liked): static
    {
        $this->liked = $liked;

        return $this;
    }
}
