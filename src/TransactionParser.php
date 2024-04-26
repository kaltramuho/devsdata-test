<?php

namespace App;

/**
 * Parses transactions from a file.
 */
class TransactionParser
{
    /**
     * Parses a file containing JSON-encoded transaction data.
     * @param string $filePath Path to the input file.
     * @return array An array of transaction data arrays.
     */
    public function parseTransactionsFromFile(string $filePath): array
    {
        $transactions = [];
        foreach (explode("\n", file_get_contents($filePath)) as $row) {
            if (!empty($row)) {
                $transactions[] = json_decode($row, true);
            }
        }
        return $transactions;
    }
}
