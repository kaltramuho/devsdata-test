# Transaction Commission Calculator

This project provides a PHP-based solution for calculating transaction commissions based on the country of the transaction's origin and the transaction currency. It leverages external APIs to fetch exchange rates and BIN (Bank Identification Number) data to determine the appropriate commission rate.

## Features

- Fetch exchange rates from an external API.
- Fetch BIN details to determine the transaction's country of origin.
- Calculate commissions based on whether the card was issued within the EU.
- Handle transactions provided in a JSON formatted file.

## Getting Started

### Prerequisites

- PHP 7.4 or higher
- Composer for managing PHP dependencies

### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/kaltramuho/devsdata-test.git
   cd devsdata-test
   ```

2. **Install dependencies:**

   ```bash
   composer install
   ```

3. **Set up environment variables:**

   Copy the `.env.example` file to a new file named `.env`, and update it with the appropriate values.

### Usage

Run the application using the PHP command line:

```bash
php app.php path/to/input.txt
```

Replace `path/to/input.txt` with the path to your input file containing JSON formatted transaction data.

### Input File Format

The input file should contain one JSON object per line, each representing a transaction. For example:

```json
{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
{"bin":"45417360","amount":"10000.00","currency":"JPY"}
```

### Output

The output will be a series of lines, each representing the calculated commission for the corresponding transaction in the input file.

## Development

### Directory Structure

```
/src
    /Services
        ExchangeService.php
        BinService.php
    CommissionCalculator.php
    TransactionParser.php
/tests
    CommissionCalculatorTest.php
    TransactionParserTest.php
composer.json
app.php
```

### Testing

Run the unit tests with PHPUnit:

```bash
./vendor/bin/phpunit tests
```

This will execute all defined tests and output the results, ensuring the application's logic is functioning as expected.

## Development Time

The project was completed in a total of 3 hours, with the time distributed across the various tasks as follows:

- **Coding the Application Logic**: Approximately 1 hour was spent on writing the main PHP classes (`CommissionCalculator`, `TransactionParser`, and services).
- **Setting Up External API Integrations**: About 1 hour was dedicated to integrating and configuring the external services (`ExchangeService` and `BinService`).
- **Writing Tests and Documentation**: The final hour was used to write unit tests for the PHP classes and to compose this comprehensive `README.md`.
