<?php

namespace App\Entity;

use App\Repository\PlnCalculationResultsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlnCalculationResultsRepository::class)]
class PlnCalculationResults extends CalculationResults
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups("calculation_results")]
    #[ORM\Column]
    private ?float $fullCostIfNotChanged = null;

    #[Groups("calculation_results")]
    #[ORM\Column]
    private ?float $profitAfterWiborAnnulment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float|null
     */
    public function getFullCostIfNotChanged(): ?float
    {
        return $this->fullCostIfNotChanged;
    }

    /**
     * @param float|null $fullCostIfNotChanged
     */
    public function setFullCostIfNotChanged(?float $fullCostIfNotChanged): void
    {
        $this->fullCostIfNotChanged = $fullCostIfNotChanged;
    }

    /**
     * @return float|null
     */
    public function getProfitAfterWiborAnnulment(): ?float
    {
        return $this->profitAfterWiborAnnulment;
    }

    /**
     * @param float|null $profitAfterWiborAnnulment
     */
    public function setProfitAfterWiborAnnulment(?float $profitAfterWiborAnnulment): void
    {
        $this->profitAfterWiborAnnulment = $profitAfterWiborAnnulment;
    }

}
