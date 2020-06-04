<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TrickGroup", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trickGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="trick")
     */
    private $trickPicture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick")
     */
    private $trickVideo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick")
     */
    private $trickComment;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Picture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainPicture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->trickPicture = new ArrayCollection();
        $this->trickVideo = new ArrayCollection();
        $this->trickComment = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    /**
     * @param TrickGroup|null $trickGroup
     * @return Trick
     * @deprecated use TrickGroup::addTrick or TrickGroup::removeTrick instead
     */
    public function setTrickGroup(?TrickGroup $trickGroup): self
    {
        $this->trickGroup = $trickGroup;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getTrickPicture(): Collection
    {
        return $this->trickPicture;
    }

    public function addTrickPicture(Picture $trickPicture): self
    {
        if (!$this->trickPicture->contains($trickPicture)) {
            $this->trickPicture[] = $trickPicture;
            $trickPicture->setTrick($this);
        }

        return $this;
    }

    public function removeTrickPicture(Picture $trickPicture): self
    {
        if ($this->trickPicture->contains($trickPicture)) {
            $this->trickPicture->removeElement($trickPicture);
            // set the owning side to null (unless already changed)
            if ($trickPicture->getTrick() === $this) {
                $trickPicture->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getTrickVideo(): Collection
    {
        return $this->trickVideo;
    }

    public function addTrickVideo(Video $trickVideo): self
    {
        if (!$this->trickVideo->contains($trickVideo)) {
            $this->trickVideo[] = $trickVideo;
            $trickVideo->setTrick($this);
        }

        return $this;
    }

    public function removeTrickVideo(Video $trickVideo): self
    {
        if ($this->trickVideo->contains($trickVideo)) {
            $this->trickVideo->removeElement($trickVideo);
            // set the owning side to null (unless already changed)
            if ($trickVideo->getTrick() === $this) {
                $trickVideo->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getTrickComment(): Collection
    {
        return $this->trickComment;
    }

    public function addTrickComment(Comment $trickComment): self
    {
        if (!$this->trickComment->contains($trickComment)) {
            $this->trickComment[] = $trickComment;
            $trickComment->setTrick($this);
        }

        return $this;
    }

    public function removeTrickComment(Comment $trickComment): self
    {
        if ($this->trickComment->contains($trickComment)) {
            $this->trickComment->removeElement($trickComment);
            // set the owning side to null (unless already changed)
            if ($trickComment->getTrick() === $this) {
                $trickComment->setTrick(null);
            }
        }

        return $this;
    }

    public function getMainPicture(): ?Picture
    {
        return $this->mainPicture;
    }

    public function setMainPicture(?Picture $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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