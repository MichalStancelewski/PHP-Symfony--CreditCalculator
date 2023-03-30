<?php

namespace App\DTO;

use App\Entity\CalculationResults;
use App\Entity\Clients;
use App\Entity\CreditData;

interface CalculationEnquiryInterface
{
    public function getClient(): ?Clients;
    public function getCreditData(): ?CreditData;
    public function getCalculationResults(): ?CalculationResults;

    public function setCalculationResults(?CalculationResults $CalculationResults);
}