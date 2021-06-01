<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $Titre;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEvent;

    /**
     * @ORM\ManyToOne(targetEntity=Sponsor::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sponsorevent;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg" ,"image/png"})
     */
    private $image;

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getSponsorevent(): ?Sponsor
    {
        return $this->sponsorevent;
    }

    public function setSponsorevent(?Sponsor $sponsorevent): self
    {
        $this->sponsorevent = $sponsorevent;

        return $this;
    }
    /**
 * Transform to string
 * 
 * @return string
 */
public function __toString()
{
    return (string) $this->getId();
}

public function getImage()
{
    return $this->image;
}

public function setImage($image)
{
    $this->image = $image;

    return $this;
}
}
