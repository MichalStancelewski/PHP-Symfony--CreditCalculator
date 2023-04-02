<?php

namespace App\Filter\Calculations;

use App\DTO\CalculationEnquiryInterface;
use App\Entity\CalculationResults;
use App\Service\ServiceException;
use App\Service\ServiceExceptionData;

class ChfCalculation implements CalculationInterface
{

    public function modify(CalculationEnquiryInterface $enquiry): CalculationResults
    {/*
        $exception = new ServiceExceptionData();
        throw new ServiceException();*/
    }

}