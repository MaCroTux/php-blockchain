<?php

namespace Blockchain\Node;

class InMemoryTransactionPool implements MemPool
{
    /** @var array */
    private $transactions;

    public function __construct(array $transactions = [])
    {
        $this->transactions = $transactions;
    }

    public function addTransaction(Transaction $transaction): void
    {
        $this->transactions[$transaction->sha1()] = $transaction;
    }

    public function transactions(): array
    {
        return $this->transactions;
    }

    public function transactionsToPlain(): array
    {
        return array_map(
            static function (Transaction $transaction) {
                return $transaction->toArray();
            },
            $this->transactions
        );
    }

    public function transactionsToPlainAndDelete(): array
    {
        $transactions = array_map(
            static function (Transaction $transaction) {
                return $transaction->toArray();
            },
            $this->transactions
        );

        $transactionsHash = array_map(
            static function (Transaction $transaction) {
                return $transaction->sha1();
            },
            $this->transactions
        );

        $this->transactions = array_filter(
            $this->transactions,
            static function (Transaction $transaction) use ($transactionsHash) {
                return !in_array($transaction->sha1(), $transactionsHash);
            }
        );

        return $transactions;
    }

    public function hasTransactions(): bool
    {
        return count($this->transactions) > 0;
    }
}