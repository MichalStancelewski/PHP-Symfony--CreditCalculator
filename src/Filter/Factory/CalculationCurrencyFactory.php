<?php

namespace App\Filter\Factory;

use App\Filter\Calculations\CalculationInterface;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

class CalculationCurrencyFactory implements CalculationCurrencyFactoryInterface
{

    public function create(string $currencyType): CalculationInterface
    {
        $currencyClassBasename = ucwords(strtolower($currencyType));

        $filter = self::CALCULATION_FILTER_NAMESPACE . $currencyClassBasename . self::CALCULATION_CLASS_SUFFIX;

        if (!class_exists($filter)) {
            throw new ClassNotFoundException($filter);
        }

        return new $filter();
    }
}