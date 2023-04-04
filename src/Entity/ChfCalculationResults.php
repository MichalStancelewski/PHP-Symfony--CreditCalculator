<?php

namespace App\Entity;

use App\Repository\ChfCalculationResultsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ChfCalculationResultsRepository::class)]
class ChfCalculationResults extends CalculationResults
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups("calculation_results")]
    #[ORM\Column]
    private ?float $overpaidInstallments = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float|null
     */
    public function getOverpaidInstallments(): ?float
    {
        return $this->overpaidInstallments;
    }

    /**
     * @param float|null $overpaidInstallments
     */
    public function setOverpaidInstallments(?float $overpaidInstallments): void
    {
        $this->overpaidInstallments = $overpaidInstallments;
    }

}

