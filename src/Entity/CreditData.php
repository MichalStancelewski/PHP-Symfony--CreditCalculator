<?php

namespace App\Entity;

use App\Repository\CreditDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditDataRepository::class)]
class CreditData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $currency = null;

    #[ORM\Column]
    private ?float $value = null;

    #[ORM\Column(length: 4)]
    private ?string $startYear = null;

    #[ORM\Column(length: 2)]
    private ?string $startMonth = null;

    #[ORM\Column]
    private ?int $period = null;

    #[ORM\Column(nullable: true)]
    private ?float $margin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getStartYear(): ?string
    {
        return $this->startYear;
    }

    public function setStartYear(string $startYear): self
    {
        $this->startYear = $startYear;

        return $this;
    }

    public function getStartMonth(): ?string
    {
        return $this->startMonth;
    }

    public function setStartMonth(string $startMonth): self
    {
        $this->startMonth = $startMonth;

        return $this;
    }

    public function getPeriod(): ?int
    {
        return $this->period;
    }

    public function setPeriod(int $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getMargin(): ?float
    {
        return $this->margin;
    }

    public function setMargin(?float $margin): self
    {
        $this->margin = $margin;

        return $this;
    }

}
