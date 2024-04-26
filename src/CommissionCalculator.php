<?php

namespace App;

use App\Services\ExchangeService;
use App\Services\BinService;

/**
 * Calculates commissions for transactions.
 */
class CommissionCalculator
{
    private $exchangeService;
    private $binService;

    const EU_COUNTRIES = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI',
        'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT',
        'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
    ];

    /**
     * @param ExchangeService $exchangeService Service to fetch exchange rates.
     * @param BinService $binService Service to fetch BIN information.
     */
    public function __construct(ExchangeService $exchangeService, BinService $binService)
    {
        $this->exchangeService = $exchangeService;
        $this->binService = $binService;
    }

    /**
     * Checks if a given country code is an EU member state.
     * @param string $countryCode The ISO alpha-2 country code to check.
     * @return bool Returns true if the country is in the EU, false otherwise.
     */
    public function isEuCountry(string $countryCode): bool {
        return in_array($countryCode, self::EU_COUNTRIES);
    }

    /**
     * Calculates the commission based on transaction data.
     * @param array $transaction Transaction data.
     * @return float Commission amount, rounded to two decimal places.
     */
    public function calculateCommission(array $transaction): float
    {
        $bin = $transaction['bin'];
        $amount = $transaction['amount'];
        $currency = $transaction['currency'];

        $rate = $this->exchangeService->getRate($currency);
        $countryCode = $this->binService->getCountryCode($bin);

        $amountInEur = $currency === 'EUR' ? $amount : $amount / $rate;
        $isEu = $this->isEuCountry($countryCode);

        $commission = $amountInEur * ($isEu ? 0.01 : 0.02);
        return ceil($commission * 100) / 100;  // Ceiling by cents
    }
}
