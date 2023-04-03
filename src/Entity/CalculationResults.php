<?php

namespace App\Entity;

use App\Repository\CalculationResultsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalculationResultsRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn("type", "string")]

abstract class CalculationResults implements EnquiryInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $calculationDate = null;

    #[ORM\Column]
    private ?float $repayedSoFar = null;

    #[ORM\Column]
    private ?float $profitAfterCreditAnnulment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCalculationDate(): ?string
    {
        return $this->calculationDate;
    }

    /**
     * @param string|null $calculationDate
     */
    public function setCalculationDate(?string $calculationDate): void
    {
        $this->calculationDate = $calculationDate;
    }

    /**
     * @return float|null
     */
    public function getRepayedSoFar(): ?float
    {
        return $this->repayedSoFar;
    }

    /**
     * @param float|null $repayedSoFar
     */
    public function setRepayedSoFar(?float $repayedSoFar): void
    {
        $this->repayedSoFar = $repayedSoFar;
    }

    /**
     * @return float|null
     */
    public function getProfitAfterCreditAnnulment(): ?float
    {
        return $this->profitAfterCreditAnnulment;
    }

    /**
     * @param float|null $profitAfterCreditAnnulment
     */
    public function setProfitAfterCreditAnnulment(?float $profitAfterCreditAnnulment): void
    {
        $this->profitAfterCreditAnnulment = $profitAfterCreditAnnulment;
    }

}
