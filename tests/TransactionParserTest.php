<?php

use PHPUnit\Framework\TestCase;
use App\TransactionParser;

/**
 * Tests for the TransactionParser class.
 */
class TransactionParserTest extends TestCase
{
    /**
     * Test parsing transactions from a file.
     */
    public function testParseTransactionsFromFile()
    {
        // Create a temporary file with some JSON content similar to the example provided
        $tempFile = tmpfile();
        $data = [
            '{"bin":"45717360","amount":"100.00","currency":"EUR"}',
            '{"bin":"516793","amount":"50.00","currency":"USD"}'
        ];
        fwrite($tempFile, implode("\n", $data));
        $path = stream_get_meta_data($tempFile)['uri'];  // Get the temporary file's path

        $parser = new TransactionParser();
        $transactions = $parser->parseTransactionsFromFile($path);

        // Check that we get the expected number of transactions
        $this->assertCount(2, $transactions);

        // Check specific details about the first transaction
        $this->assertEquals('45717360', $transactions[0]['bin']);
        $this->assertEquals('100.00', $transactions[0]['amount']);
        $this->assertEquals('EUR', $transactions[0]['currency']);

        // Check specific details about the second transaction
        $this->assertEquals('516793', $transactions[1]['bin']);
        $this->assertEquals('50.00', $transactions[1]['amount']);
        $this->assertEquals('USD', $transactions[1]['currency']);

        // Close and remove the temporary file
        fclose($tempFile);
    }

    /**
     * Test parsing an empty file.
     */
    public function testParseEmptyFile()
    {
        // Create an empty temporary file
        $tempFile = tmpfile();
        $path = stream_get_meta_data($tempFile)['uri'];  // Get the temporary file's path

        $parser = new TransactionParser();
        $transactions = $parser->parseTransactionsFromFile($path);

        // Check that no transactions are returned from an empty file
        $this->assertEmpty($transactions);

        // Close and remove the temporary file
        fclose($tempFile);
    }
}
