<?php

declare(strict_types=1);

namespace Blockchain;

use Blockchain\Node\MemPool;
use Blockchain\Node\Message;
use Blockchain\Node\P2pServer;
use Blockchain\Node\Peer;
use Blockchain\Node\Transaction;

final class Node
{
    /** @var Miner */
    private $miner;
    /** @var P2pServer */
    private $p2pServer;
    /** @var MemPool */
    private $memPool;

    public function __construct(Miner $miner, P2pServer $p2pServer, MemPool $memPool)
    {
        $this->miner = $miner;
        $this->p2pServer = $p2pServer;
        $this->memPool = $memPool;
    }

    /**
     * @return Block[]
     */
    public function blocks(): array
    {
        return $this->miner->blockchain()->blocks();
    }

    public function mineBlock(string $data): ?Block
    {
        $block = $this->miner->mineBlock($data, $this->memPool);

        if (null === $block) {
            return $block;
        }

        $this->p2pServer->broadcast(new Message(Message::BLOCKCHAIN, serialize($this->blockchain()->withLastBlockOnly())));

        return $block;
    }

    /**
     * @return Peer[]
     */
    public function peers(): array
    {
        return $this->p2pServer->peers();
    }

    public function connect(string $host, int $port): void
    {
        $this->p2pServer->connect($host, $port);
    }

    public function blockchain(): Blockchain
    {
        return $this->miner->blockchain();
    }

    public function replaceBlockchain(Blockchain $blockchain): void
    {
        $this->miner->replaceBlockchain($blockchain);
    }

    public function addTransaction(string $getContents): array
    {
        $this->memPool->addTransaction(new Transaction($getContents));

        return [];
    }

    /**
     * @return array<Transaction>
     */
    public function transactions(): array
    {
        return $this->memPool->transactionsToPlain();
    }
}
