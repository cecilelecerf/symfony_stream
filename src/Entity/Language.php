<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'language', targetEntity: MediaLanguage::class, orphanRemoval: true)]
    private Collection $mediaLanguages;

    public function __construct()
    {
        $this->mediaLanguages = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, MediaLanguage>
     */
    public function getMediaLanguages(): Collection
    {
        return $this->mediaLanguages;
    }

    public function addMediaLanguage(MediaLanguage $mediaLanguage): self
    {
        if (!$this->mediaLanguages->contains($mediaLanguage)) {
            $this->mediaLanguages->add($mediaLanguage);
            $mediaLanguage->setLanguage($this);
        }

        return $this;
    }

    public function removeMediaLanguage(MediaLanguage $mediaLanguage): self
    {
        if ($this->mediaLanguages->removeElement($mediaLanguage)) {
            // set the owning side to null (unless already changed)
            if ($mediaLanguage->getLanguage() === $this) {
                $mediaLanguage->setLanguage(null);
            }
        }

        return $this;
    }
}
