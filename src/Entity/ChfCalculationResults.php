<?php

namespace App\Entity;

use App\Repository\ChfCalculationResultsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChfCalculationResultsRepository::class)]
class ChfCalculationResults extends CalculationResults
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
