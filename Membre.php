<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MembreRepository::class)
 */
class Membre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameMembre;

    /**
     * @ORM\Column(type="bigint")
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailmembre;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDeNaissance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMembre(): ?string
    {
        return $this->nameMembre;
    }

    public function setNameMembre(string $nameMembre): self
    {
        $this->nameMembre = $nameMembre;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getEmailmembre(): ?string
    {
        return $this->emailmembre;
    }

    public function setEmailmembre(string $emailmembre): self
    {
        $this->emailmembre = $emailmembre;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $dateDeNaissance): self
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }
}
