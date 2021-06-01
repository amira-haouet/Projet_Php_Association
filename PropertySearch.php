<?php

namespace App\Entity;

class PropertySearch
{

   private $nameMembre;

   
   public function getNameMembre(): ?string
   {
       return $this->nameMembre;
   }
   public function setNameMembre(string $nameMembre): self
   {
       $this->nameMembre = $nameMembre;

       return $this;
   }
}