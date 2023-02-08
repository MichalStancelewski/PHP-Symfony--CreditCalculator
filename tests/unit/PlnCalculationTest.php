<?php

namespace App\Tests\unit;

use App\DTO\CalculateRequestDTO;
use App\Entity\Clients;
use App\Entity\CreditData;
use App\Entity\PlnCalculationResults;
use App\Filter\CalculationFilter;
use App\Tests\ServiceTestCase;

class PlnCalculationTest extends ServiceTestCase
{
    /** @test */
    public function pln_credit_is_calculated_correctly(): void
    {
        // Given
        $client = new Clients();
        $creditData = new CreditData();
        $creditData->setCurrency('PLN');
        $creditData->setValue(300000.00);
        $creditData->setStartYear('2005');
        $creditData->setStartMonth('01');
        $creditData->setPeriod('30');
        $creditData->setInstallmentType(null);
        $creditData->setMargin(null);

        $enquiry = new CalculateRequestDTO();
        $enquiry->setClient($client);
        $enquiry->setCreditData($creditData);

        $calculationFilter = $this->container->get(CalculationFilter::class);

        // When
        $filteredEnquiry = $calculationFilter->apply($enquiry);

        date_default_timezone_set('Europe/Warsaw');
        $currentDateTime = date('Y-m-d H:i');

        // Then
        $calculationResults = $filteredEnquiry->getCalculationResults();
        $this->assertSame(383298.45, $calculationResults->getRepayedSoFar());
        $this->assertSame(679864.66, $calculationResults->getFullCostIfNotChanged());
        $this->assertSame(269787.75, $calculationResults->getProfitAfterWiborAnnulment());
        $this->assertSame(379864.66, $calculationResults->getProfitAfterCreditAnnulment());
        $this->assertStringStartsWith($currentDateTime, $calculationResults->getCalculationDate());
    }

}