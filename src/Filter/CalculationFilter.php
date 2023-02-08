<?php

namespace App\Filter;

use App\DTO\CalculationEnquiryInterface;
use App\Entity\PlnCalculationResults;
use Symfony\Component\Finder\SplFileInfo;

class CalculationFilter implements CalculationsFilterInterface
{
    const PATH_TO_WIBOR_JSON = __DIR__ . '/Resources/wibor.json';

    const DEFAULT_CREDIT_MARGIN_PLN = 2.2;
    const DEFAULT_CREDIT_MARGIN_CHF = 2.0;

    const DEFAULT_CREDIT_INSTALLMENT_TYPE_PLN = 1;
    const DEFAULT_CREDIT_INSTALLMENT_TYPE_CHF = 1;

    // INSTALLMENT_TYPE: 1="equal", 2="decreasing"
    private static array $allowedInstallmentTypes = [1, 2];

    public function apply(CalculationEnquiryInterface $enquiry): CalculationEnquiryInterface
    {
        $calculationResults = new PlnCalculationResults();

        $creditData = $enquiry->getCreditData();

        if ($creditData->getCurrency() === "PLN") {

            $creditAmount = $creditData->getValue();
            $creditLength = $creditData->getPeriod() * 12;
            $creditDate =  $creditData->getStartYear() . '-' . $creditData->getStartMonth();

            if( $creditData->getMargin() == null){
                $creditData->setMargin(self::DEFAULT_CREDIT_MARGIN_PLN);
            }
            $creditMargin =  $creditData->getMargin();


            if($creditData->getInstallmentType() == null){
                $creditData->setInstallmentType(self::DEFAULT_CREDIT_INSTALLMENT_TYPE_PLN);
            }
            $installmentType =  $creditData->getInstallmentType();

            $calculationResults = new PlnCalculationResults();

            date_default_timezone_set('Europe/Warsaw');
            $currentDateTime = date('Y-m-d H:i:s');

            $iterator = $creditLength;

            $numberOfInstallmentsPaid = 0;
            $currentWiborPlusMargin = 0;

            $currentCreditAmount = $creditAmount;

            $sumOfCapitalInstallments = 0;
            $sumOfInterestInstallments = 0;
            $sumOfTotalInstallments = 0;
            $currentTotalInstallment = 0;

            $sumOfCapitalInstallmentsWithoutWibor = 0;
            $sumOfInterestInstallmentsWithoutWibor = 0;
            $sumOfTotalInstallmentsWithoutWibor = 0;
            $creditWithoutWibor = $creditAmount;
            $currentTotalInstallmentWithoutWibor = 0;

            $jsonWibor = $this->readJsonWithWibor();

            foreach ($jsonWibor as $key => $value) {

                if ($key >= $creditDate) {
                    $wiborPlusMargin = ($value+$creditMargin) * 0.01 / 12;
                    $marginOnly = $creditMargin * 0.01 / 12;

                    $interestInstallment = $currentCreditAmount * ($wiborPlusMargin);
                    $totalInstallment = $currentCreditAmount * (($wiborPlusMargin * pow(1+$wiborPlusMargin, $iterator)) / (pow(1+$wiborPlusMargin, $iterator) -1));
                    $capitalInstallment = $totalInstallment - $interestInstallment;

                    $interestInstallmentWithoutWibor = $currentCreditAmount * ($marginOnly);
                    $totalInstallmentWithoutWibor = $currentCreditAmount * (($marginOnly * pow(1+$marginOnly, $iterator)) / (pow(1+$marginOnly, $iterator) -1));
                    $capitalInstallmentWithoutWibor = $totalInstallmentWithoutWibor - $interestInstallmentWithoutWibor;

                    $currentCreditAmount = $currentCreditAmount - $capitalInstallment;
                    $sumOfCapitalInstallments = $sumOfCapitalInstallments + $capitalInstallment;
                    $sumOfInterestInstallments = $sumOfInterestInstallments + $interestInstallment;
                    $sumOfTotalInstallments = $sumOfTotalInstallments + $totalInstallment;
                    $currentTotalInstallment = $totalInstallment;
                    $currentWiborPlusMargin = $wiborPlusMargin;

                    $creditWithoutWibor = $creditWithoutWibor - $capitalInstallmentWithoutWibor;
                    $sumOfCapitalInstallmentsWithoutWibor = $sumOfCapitalInstallmentsWithoutWibor + $capitalInstallmentWithoutWibor;
                    $sumOfInterestInstallmentsWithoutWibor = $sumOfInterestInstallmentsWithoutWibor + $interestInstallmentWithoutWibor;
                    $sumOfTotalInstallmentsWithoutWibor = $sumOfTotalInstallmentsWithoutWibor + $totalInstallmentWithoutWibor;

                    if($currentTotalInstallmentWithoutWibor == 0){
                        $currentTotalInstallmentWithoutWibor = $totalInstallmentWithoutWibor;
                    }

                    $numberOfInstallmentsPaid++;

                    if ($iterator-- < 1) break;
                }

            }
            $numberOfInstallmentsRemaining = $creditLength - $numberOfInstallmentsPaid;
            $totalAmountRemaining = $numberOfInstallmentsRemaining * $currentTotalInstallment;

            $repayedSoFar = $sumOfTotalInstallments;
            $fullCostIfNotChanged = $totalAmountRemaining + $repayedSoFar;
            $profitAfterCreditAnnulment = $fullCostIfNotChanged - $creditAmount;
            $profitAfterWiborAnnulment = $fullCostIfNotChanged - ($currentTotalInstallmentWithoutWibor * $creditLength);


            $repayedSoFar = number_format(round($repayedSoFar,2), 2, '.', '');
            $fullCostIfNotChanged = number_format(round($fullCostIfNotChanged,2), 2, '.', '');
            $profitAfterCreditAnnulment = number_format(round($profitAfterCreditAnnulment,2), 2, '.', '');
            $profitAfterWiborAnnulment = number_format(round($profitAfterWiborAnnulment,2), 2, '.', '');


            $calculationResults->setRepayedSoFar($repayedSoFar);
            $calculationResults->setFullCostIfNotChanged($fullCostIfNotChanged);
            $calculationResults->setProfitAfterCreditAnnulment($profitAfterCreditAnnulment);
            $calculationResults->setProfitAfterWiborAnnulment($profitAfterWiborAnnulment);
            $calculationResults->setCalculationDate($currentDateTime);

            $enquiry->setCalculationResults($calculationResults);
            return $enquiry;
        }

        if ($enquiry->getCreditData()->getCurrency() === "CHF") {

            return $enquiry;
        }

        //TODO throw ERROR method not found
    }

    private function readJsonWithWibor()
    {
        $file = new SplFileInfo(self::PATH_TO_WIBOR_JSON, '','');
        return $jsonData = json_decode($file->getContents(),true);
    }

}