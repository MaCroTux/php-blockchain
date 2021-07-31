<?php

namespace Blockchain\Node;

interface MemPool
{
    public function addTransaction(Transaction $transaction): void;
    public function transactions(): array;
    public function transactionsToPlain(): array;
    public function transactionsToPlainAndDelete(): array;
    public function hasTransactions(): bool;
}