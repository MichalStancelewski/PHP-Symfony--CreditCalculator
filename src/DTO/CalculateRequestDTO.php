<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CalculateRequestDTO implements CalculationEnquiryInterface
{
    #[Assert\NotBlank]
    private ?int $calculationId;

    private ?Clients $client;

    private ?CreditData $creditData;

    private ?CalculationResults $calculationResults;

    #[Assert\NotBlank]
    private ?string $calculationDate;

    /**
     * @return int|null
     */
    public function getCalculationId(): ?int
    {
        return $this->calculationId;
    }

    /**
     * @param int|null $calculationId
     */
    public function setCalculationId(?int $calculationId): void
    {
        $this->calculationId = $calculationId;
    }

    /**
     * @return Clients|null
     */
    public function getClient(): ?Clients
    {
        return $this->client;
    }

    /**
     * @param Clients|null $client
     */
    public function setClient(?Clients $client): void
    {
        $this->client = $client;
    }

    /**
     * @return CreditData|null
     */
    public function getCreditData(): ?CreditData
    {
        return $this->creditData;
    }

    /**
     * @param CreditData|null $creditData
     */
    public function setCreditData(?CreditData $creditData): void
    {
        $this->creditData = $creditData;
    }

    /**
     * @return CalculationResults|null
     */
    public function getCalculationResults(): ?CalculationResults
    {
        return $this->calculationResults;
    }

    /**
     * @param CalculationResults|null $calculationResults
     */
    public function setCalculationResults(?CalculationResults $calculationResults): void
    {
        $this->calculationResults = $calculationResults;
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

}