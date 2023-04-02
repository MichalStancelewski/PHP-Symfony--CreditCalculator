<?php

namespace App\Filter\Factory;

use App\Filter\Calculations\CalculationInterface;
use App\Service\ServiceException;
use App\Service\ServiceExceptionData;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

class CalculationCurrencyFactory implements CalculationCurrencyFactoryInterface
{

    public function create(string $currencyType): CalculationInterface
    {
        $currencyClassBasename = ucwords(strtolower($currencyType));

        $filter = self::CALCULATION_FILTER_NAMESPACE . $currencyClassBasename . self::CALCULATION_CLASS_SUFFIX;

        if (!class_exists($filter)) {
            $exception = new ServiceExceptionData(403, 'This currency is not supported.');
            throw new ServiceException($exception);
        }

        return new $filter();
    }
}