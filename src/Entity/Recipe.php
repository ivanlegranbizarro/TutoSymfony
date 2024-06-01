<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[UniqueEntity(fields: ['slug'], message: 'There is already a recipe with this slug')]
#[UniqueEntity(fields: ['title'], message: 'There is already a recipe with this title')]
#[ORM\HasLifecycleCallbacks]
class Recipe
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank(message: 'Please enter a title.')]
  #[Assert\Length(max: 255, maxMessage: 'The title cannot be longer than {{ limit }} characters.')]
  #[Assert\Length(min: 3, minMessage: 'The title must be at least {{ limit }} characters long.')]
  private ?string $title = null;

  #[ORM\Column(length: 255)]
  private ?string $slug = null;

  #[ORM\Column(type: Types::TEXT)]
  #[Assert\NotBlank(message: 'Please enter a content.')]
  #[Assert\Length(min: 10, minMessage: 'The content must be at least {{ limit }} characters long.')]
  #[Assert\Length(max: 500, maxMessage: 'The content cannot be longer than {{ limit }} characters.')]
  private ?string $content = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $createdAt = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $updatedAt = null;

  #[ORM\Column]
  #[Assert\NotNull]
  #[Assert\Positive]
  private ?int $duration = null;


  #[ORM\PrePersist]
  public function onPrePersist(): void
  {
    $this->createdAt = new \DateTimeImmutable();
    $this->updatedAt = new \DateTimeImmutable();
  }

  #[ORM\PreUpdate]
  public function onPreUpdate(): void
  {
    $this->updatedAt = new \DateTimeImmutable();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): static
  {
    $this->title = $title;

    return $this;
  }

  public function getSlug(): ?string
  {
    return $this->slug;
  }

  public function setSlug(string $slug): static
  {
    $this->slug = $slug;

    return $this;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(string $content): static
  {
    $this->content = $content;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeImmutable $createdAt): static
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  public function getDuration(): ?int
  {
    return $this->duration;
  }

  public function setDuration(int $duration): static
  {
    $this->duration = $duration;

    return $this;
  }
}
