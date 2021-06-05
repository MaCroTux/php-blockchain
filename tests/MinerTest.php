<?php

declare(strict_types=1);

namespace Blockchain;

use Blockchain\Miner\HashDifficulty\ZeroPrefix;
use PHPUnit\Framework\TestCase;

final class MinerTest extends TestCase
{
    private const DIFFICULTY = 0;

    public function testMineNewBlockWithGivenData(): void
    {
        $miner = new Miner(new Blockchain(Block::genesis(self::DIFFICULTY)), new ZeroPrefix());
        $block = $miner->mineBlock('Working hard make you hard');

        self::assertInstanceOf(Block::class, $block);
        self::assertEquals(1, $block->index());
    }
}
