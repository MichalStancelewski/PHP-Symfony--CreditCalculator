<?php

namespace App\Filter\Factory;

use App\Filter\Calculations\CalculationInterface;

interface CalculationCurrencyFactoryInterface
{
    const CALCULATION_FILTER_NAMESPACE = "App\Filter\Calculations\\";
    const CALCULATION_CLASS_SUFFIX = "Calculation";

    public function create(string $currencyType) : CalculationInterface;
}