<?php

require_once __DIR__.'/vendor/autoload.php';

use App\TransactionParser;
use App\CommissionCalculator;
use App\Services\ExchangeService;
use App\Services\BinService;
use GuzzleHttp\Client;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiUrl = $_ENV['API_URL'];
$apiKey = $_ENV['API_KEY'];
$binServiceUrl = $_ENV['BIN_SERVICE_URL'];

$exchangeService = new ExchangeService(new Client(), $apiUrl, $apiKey);
$binService = new BinService(new Client(), $binServiceUrl);
$calculator = new CommissionCalculator($exchangeService, $binService);

$parser = new TransactionParser();
$transactions = $parser->parseTransactionsFromFile($argv[1]);

foreach ($transactions as $transaction) {
    echo $calculator->calculateCommission($transaction) . "\n";
}
