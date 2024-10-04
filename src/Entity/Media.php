<?php

namespace App\Entity;

use App\Enum\MediaMediaTypeEnum;
use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: MediaMediaTypeEnum::class)]
    private MediaMediaTypeEnum $media_type;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $short_description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $long_description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column(length: 255)]
    private ?string $cover_image = null;

    #[ORM\Column]
    private array $staff = [];

    #[ORM\Column]
    private array $cast = [];

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: WatchHistory::class, orphanRemoval: true)]
    private Collection $watchHistories;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: PlaylistMedia::class)]
    private Collection $playlistMedia;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: MediaLanguage::class, orphanRemoval: true)]
    private Collection $mediaLanguages;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: CategoryMedia::class, orphanRemoval: true)]
    private Collection $categoryMedia;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->watchHistories = new ArrayCollection();
        $this->playlistMedia = new ArrayCollection();
        $this->mediaLanguages = new ArrayCollection();
        $this->categoryMedia = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMediaType(): MediaMediaTypeEnum
    {
        return $this->media_type;
    }

    public function setMediaType(MediaMediaTypeEnum $media_type): self
    {
        $this->media_type = $media_type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->long_description;
    }

    public function setLongDescription(string $long_description): self
    {
        $this->long_description = $long_description;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->cover_image;
    }

    public function setCoverImage(string $cover_image): self
    {
        $this->cover_image = $cover_image;

        return $this;
    }

    public function getStaff(): array
    {
        return $this->staff;
    }

    public function setStaff(array $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function getCast(): array
    {
        return $this->cast;
    }

    public function setCast(array $cast): self
    {
        $this->cast = $cast;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setMedia($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMedia() === $this) {
                $comment->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WatchHistory>
     */
    public function getWatchHistories(): Collection
    {
        return $this->watchHistories;
    }

    public function addWatchHistory(WatchHistory $watchHistory): self
    {
        if (!$this->watchHistories->contains($watchHistory)) {
            $this->watchHistories->add($watchHistory);
            $watchHistory->setMedia($this);
        }

        return $this;
    }

    public function removeWatchHistory(WatchHistory $watchHistory): self
    {
        if ($this->watchHistories->removeElement($watchHistory)) {
            // set the owning side to null (unless already changed)
            if ($watchHistory->getMedia() === $this) {
                $watchHistory->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlaylistMedia>
     */
    public function getPlaylistMedia(): Collection
    {
        return $this->playlistMedia;
    }

    public function addPlaylistMedium(PlaylistMedia $playlistMedium): self
    {
        if (!$this->playlistMedia->contains($playlistMedium)) {
            $this->playlistMedia->add($playlistMedium);
            $playlistMedium->setMedia($this);
        }

        return $this;
    }

    public function removePlaylistMedium(PlaylistMedia $playlistMedium): self
    {
        if ($this->playlistMedia->removeElement($playlistMedium)) {
            // set the owning side to null (unless already changed)
            if ($playlistMedium->getMedia() === $this) {
                $playlistMedium->setMedia(null);
            }
        }

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
            $mediaLanguage->setMedia($this);
        }

        return $this;
    }

    public function removeMediaLanguage(MediaLanguage $mediaLanguage): self
    {
        if ($this->mediaLanguages->removeElement($mediaLanguage)) {
            // set the owning side to null (unless already changed)
            if ($mediaLanguage->getMedia() === $this) {
                $mediaLanguage->setMedia(null);
            }
        }

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
            $categoryMedium->setMedia($this);
        }

        return $this;
    }

    public function removeCategoryMedium(CategoryMedia $categoryMedium): self
    {
        if ($this->categoryMedia->removeElement($categoryMedium)) {
            // set the owning side to null (unless already changed)
            if ($categoryMedium->getMedia() === $this) {
                $categoryMedium->setMedia(null);
            }
        }

        return $this;
    }
}
