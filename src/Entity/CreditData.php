<?php

namespace App\Entity;

use App\Repository\CreditDataRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CreditDataRepository::class)]
class CreditData implements EnquiryInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Currency]
    #[ORM\Column(length: 255)]
    private ?string $currency = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[ORM\Column]
    private ?float $value = null;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(value: 1995)]
    #[Assert\LessThan(value: 2023)]
    #[Assert\Length(4)]
    #[ORM\Column(length: 4)]
    private ?string $startYear = null;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(value: 0)]
    #[Assert\LessThan(value: 13)]
    #[Assert\LessThan(value: 13)]
    #[Assert\Length(2)]
    #[ORM\Column(length: 2)]
    private ?string $startMonth = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[ORM\Column]
    private ?int $period = null;

    #[ORM\Column(nullable: true)]
    private ?float $margin = null;

    #[ORM\OneToOne(inversedBy: 'creditData', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CalculationResults $CalculationResults = null;

    #[ORM\ManyToOne(inversedBy: 'creditData')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clients $clients = null;

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

    public function getCalculationResults(): ?CalculationResults
    {
        return $this->CalculationResults;
    }

    public function setCalculationResults(CalculationResults $CalculationResults): self
    {
        $this->CalculationResults = $CalculationResults;

        return $this;
    }

    public function getClients(): ?Clients
    {
        return $this->clients;
    }

    public function setClients(?Clients $clients): self
    {
        $this->clients = $clients;

        return $this;
    }

}
