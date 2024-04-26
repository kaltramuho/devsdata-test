<?php

use PHPUnit\Framework\TestCase;
use App\CommissionCalculator;
use App\Services\ExchangeService;
use App\Services\BinService;

/**
 * Tests for the CommissionCalculator class.
 */
class CommissionCalculatorTest extends TestCase
{
    /**
     * Test the commission calculation logic.
     */
    public function testCalculateCommission()
    {
        $exchangeServiceMock = $this->createMock(ExchangeService::class);
        $exchangeServiceMock->method('getRate')->willReturn(1.0);  // Mock the exchange rate for EUR

        $binServiceMock = $this->createMock(BinService::class);
        $binServiceMock->method('getCountryCode')->willReturn('DE');  // Mock the country code

        $calculator = new CommissionCalculator($exchangeServiceMock, $binServiceMock);
        $transaction = ['bin' => '123456', 'amount' => 100, 'currency' => 'EUR'];

        $this->assertEquals(1.0, $calculator->calculateCommission($transaction));
    }
}
