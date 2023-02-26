<?php

namespace App\Filter\Calculations;

use App\DTO\CalculationEnquiryInterface;
use App\Entity\CalculationResults;

interface CalculationInterface
{
    public function modify(CalculationEnquiryInterface $enquiry): CalculationResults ;
}