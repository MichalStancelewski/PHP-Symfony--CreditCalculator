<?php

namespace App\Entity;

use App\Repository\PlnCalculationResultsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlnCalculationResultsRepository::class)]
class PlnCalculationResults extends CalculationResults
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $repayedSoFar = null;

    #[ORM\Column]
    private ?float $fullCostIfNotChanged = null;

    #[ORM\Column]
    private ?float $profitAfterWiborAnnulment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepayedSoFar(): ?float
    {
        return $this->repayedSoFar;
    }

    public function setRepayedSoFar(float $repayedSoFar): self
    {
        $this->repayedSoFar = $repayedSoFar;

        return $this;
    }

    public function getFullCostIfNotChanged(): ?float
    {
        return $this->fullCostIfNotChanged;
    }

    public function setFullCostIfNotChanged(float $fullCostIfNotChanged): self
    {
        $this->fullCostIfNotChanged = $fullCostIfNotChanged;

        return $this;
    }

    public function getProfitAfterWiborAnnulment(): ?float
    {
        return $this->profitAfterWiborAnnulment;
    }

    public function setProfitAfterWiborAnnulment(float $profitAfterWiborAnnulment): self
    {
        $this->profitAfterWiborAnnulment = $profitAfterWiborAnnulment;

        return $this;
    }
}
