<?php

namespace App\Entity;

use App\Repository\CalculationResultsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalculationResultsRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn("type", "string", 2)]

abstract class CalculationResults
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $calculationDate = null;

    #[ORM\Column]
    private ?float $profitAfterAnnulment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalculationDate(): ?\DateTimeImmutable
    {
        return $this->calculationDate;
    }

    public function setCalculationDate(\DateTimeImmutable $calculationDate): self
    {
        $this->calculationDate = $calculationDate;

        return $this;
    }

    public function getProfitAfterAnnulment(): ?float
    {
        return $this->profitAfterAnnulment;
    }

    public function setProfitAfterAnnulment(float $profitAfterAnnulment): self
    {
        $this->profitAfterAnnulment = $profitAfterAnnulment;

        return $this;
    }
}
