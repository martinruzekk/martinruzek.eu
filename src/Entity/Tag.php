<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetime_immutable')]
    private $addedAt;

    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: PostTag::class)]
    private $postTags;

    public function __construct()
    {
        $this->postTags = new ArrayCollection();
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

    public function getAddedAt(): ?\DateTimeImmutable
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeImmutable $addedAt): self
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    /**
     * @return Collection|PostTag[]
     */
    public function getPostTags(): Collection
    {
        return $this->postTags;
    }

    public function addPostTag(PostTag $postTag): self
    {
        if (!$this->postTags->contains($postTag)) {
            $this->postTags[] = $postTag;
            $postTag->setTag($this);
        }

        return $this;
    }

    public function removePostTag(PostTag $postTag): self
    {
        if ($this->postTags->removeElement($postTag)) {
            // set the owning side to null (unless already changed)
            if ($postTag->getTag() === $this) {
                $postTag->setTag(null);
            }
        }

        return $this;
    }
}
