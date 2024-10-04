<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CategoryMedia::class, orphanRemoval: true)]
    private Collection $categoryMedia;

    public function __construct()
    {
        $this->categoryMedia = new ArrayCollection();
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, CategoryMedia>
     */
    public function getCategoryMedia(): Collection
    {
        return $this->categoryMedia;
    }

    public function addCategoryMedium(CategoryMedia $categoryMedium): self
    {
        if (!$this->categoryMedia->contains($categoryMedium)) {
            $this->categoryMedia->add($categoryMedium);
            $categoryMedium->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryMedium(CategoryMedia $categoryMedium): self
    {
        if ($this->categoryMedia->removeElement($categoryMedium)) {
            // set the owning side to null (unless already changed)
            if ($categoryMedium->getCategory() === $this) {
                $categoryMedium->setCategory(null);
            }
        }

        return $this;
    }
}
