<?php

namespace App\Filter;

use App\DTO\CalculationEnquiryInterface;
use App\Entity\PlnCalculationResults;

class CalculationFilter implements CalculationsFilterInterface
{

    public function apply(CalculationEnquiryInterface $enquiry): CalculationEnquiryInterface
    {
        $calculationResults = new PlnCalculationResults();

        if ($enquiry->getCreditData()->getCurrency() === "PLN") {

            $calculationResults = new PlnCalculationResults();
            
            $repayedSoFar = 0;
            $fullCostIfNotChanged = 0;
            $ProfitAfterWiborAnnulment = 0;
            $profitAfterAnnulment = 0;


            $enquiry->setCalculationResults($calculationResults);
            return $enquiry;
        }

        if ($enquiry->getCreditData()->getCurrency() === "CHF") {

            return $enquiry;
        }

        //TODO throw ERROR method not found
    }

}