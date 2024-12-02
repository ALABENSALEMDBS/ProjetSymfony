<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le titre ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(length: 255)]
    private ?string $TitreLivre = null;

    #[Assert\NotBlank(message: "L'auteur ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom de l'auteur ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(length: 255)]
    private ?string $AuteurLivre = null;

    #[Assert\NotBlank(message: "L'ISBN ne peut pas être vide.")]
    // #[Assert\Isbn(
    //     type: Assert\Isbn::ISBN_13,
    //     message: "Veuillez fournir un ISBN valide."
    // )]
    #[ORM\Column(length: 255)]
    private ?string $IsbnLivre = null;

    #[Assert\NotBlank(message: "Le nombre d'exemplaires est requis.")]
    #[Assert\Positive(message: "Le nombre d'exemplaires doit être supérieur à zéro.")]
    #[ORM\Column]
    private ?int $NombreExemplaireLivre = null;

    // #[Assert\NotBlank(message: "L'année de publication est requise.")]
    // #[Assert\Date(message: "Veuillez fournir une date valide.")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $AnneePublicationLivre = null;

    #[ORM\Column(length: 255)]
    private ?string $ImageLivre = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?CategoryLivre $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreLivre(): ?string
    {
        return $this->TitreLivre;
    }

    public function setTitreLivre(string $TitreLivre): static
    {
        $this->TitreLivre = $TitreLivre;

        return $this;
    }

    public function getAuteurLivre(): ?string
    {
        return $this->AuteurLivre;
    }

    public function setAuteurLivre(string $AuteurLivre): static
    {
        $this->AuteurLivre = $AuteurLivre;

        return $this;
    }

    public function getIsbnLivre(): ?string
    {
        return $this->IsbnLivre;
    }

    public function setIsbnLivre(string $IsbnLivre): static
    {
        $this->IsbnLivre = $IsbnLivre;

        return $this;
    }

    public function getNombreExemplaireLivre(): ?int
    {
        return $this->NombreExemplaireLivre;
    }

    public function setNombreExemplaireLivre(int $NombreExemplaireLivre): static
    {
        $this->NombreExemplaireLivre = $NombreExemplaireLivre;

        return $this;
    }

    public function getAnneePublicationLivre(): ?\DateTimeInterface
    {
        return $this->AnneePublicationLivre;
    }

    public function setAnneePublicationLivre(\DateTimeInterface $AnneePublicationLivre): static
    {
        $this->AnneePublicationLivre = $AnneePublicationLivre;

        return $this;
    }

    public function getImageLivre(): ?string
    {
        return $this->ImageLivre;
    }

    public function setImageLivre(string $ImageLivre): static
    {
        $this->ImageLivre = $ImageLivre;

        return $this;
    }

    public function getCategory(): ?CategoryLivre
    {
        return $this->category;
    }

    public function setCategory(?CategoryLivre $category): static
    {
        $this->category = $category;

        return $this;
    }
}
