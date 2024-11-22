<?php

namespace App\Entity;

use App\Repository\ReservationEvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationEvenementRepository::class)]
class ReservationEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDebutRE = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFinRE = null;

    #[ORM\Column(length: 255)]
    private ?string $ClassReservationEvent = null;

    #[ORM\Column]
    private ?bool $StatutReservationEvent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutRE(): ?\DateTimeInterface
    {
        return $this->DateDebutRE;
    }

    public function setDateDebutRE(\DateTimeInterface $DateDebutRE): static
    {
        $this->DateDebutRE = $DateDebutRE;

        return $this;
    }

    public function getDateFinRE(): ?\DateTimeInterface
    {
        return $this->DateFinRE;
    }

    public function setDateFinRE(\DateTimeInterface $DateFinRE): static
    {
        $this->DateFinRE = $DateFinRE;

        return $this;
    }

    public function getClassReservationEvent(): ?string
    {
        return $this->ClassReservationEvent;
    }

    public function setClassReservationEvent(string $ClassReservationEvent): static
    {
        $this->ClassReservationEvent = $ClassReservationEvent;

        return $this;
    }

    public function isStatutReservationEvent(): ?bool
    {
        return $this->StatutReservationEvent;
    }

    public function setStatutReservationEvent(bool $StatutReservationEvent): static
    {
        $this->StatutReservationEvent = $StatutReservationEvent;

        return $this;
    }
}
