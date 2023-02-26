<?php

namespace App\Filter;

use App\DTO\CalculationEnquiryInterface;
use App\Entity\PlnCalculationResults;
use App\Filter\Calculations\PlnCalculation;
use Symfony\Component\Finder\SplFileInfo;

class CalculationFilter implements CalculationsFilterInterface
{


    const DEFAULT_CREDIT_MARGIN_CHF = 2.0;
    const DEFAULT_CREDIT_INSTALLMENT_TYPE_CHF = 1;

    // INSTALLMENT_TYPE: 1="equal", 2="decreasing"
    private static array $allowedInstallmentTypes = [1, 2];

    public function apply(CalculationEnquiryInterface $enquiry): CalculationEnquiryInterface
    {

        if ($enquiry->getCreditData()->getCurrency() === "PLN") {

            $plnCalculation = new PlnCalculation();
            $enquiry->setCalculationResults($plnCalculation->modify($enquiry));
            return $enquiry;

        }

        if ($enquiry->getCreditData()->getCurrency() === "CHF") {

            return $enquiry;
        }

        //TODO throw ERROR method not found
    }


}