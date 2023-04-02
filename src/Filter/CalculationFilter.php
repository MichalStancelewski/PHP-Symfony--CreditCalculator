<?php

namespace App\Filter;

use App\DTO\CalculationEnquiryInterface;
use App\Filter\Factory\CalculationCurrencyFactory;

class CalculationFilter implements CalculationsFilterInterface
{
    public function __construct(private CalculationCurrencyFactory $calculationCurrencyFactory)
    {

    }

    public function apply(CalculationEnquiryInterface $enquiry): CalculationEnquiryInterface
    {
        $currency = $enquiry->getCreditData()->getCurrency();

        $calculationFilter = $this->calculationCurrencyFactory->create($currency);
        $enquiry->setCalculationResults($calculationFilter->modify($enquiry));

        return $enquiry;

        //TODO create database

        //TODO post to database

        //TODO send emails

    }

}