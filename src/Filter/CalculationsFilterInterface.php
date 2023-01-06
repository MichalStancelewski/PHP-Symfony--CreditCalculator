<?php

namespace App\Filter;

use App\DTO\CalculationEnquiryInterface;

interface CalculationsFilterInterface
{
    public function apply(CalculationEnquiryInterface $enquiry): CalculationEnquiryInterface;
}