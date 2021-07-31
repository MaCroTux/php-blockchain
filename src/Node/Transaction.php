<?php

namespace Blockchain\Node;

class Transaction
{
    private const ALGO = 'sha256';

    /** @var string */
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function sha1(): string
    {
        return hash(self::ALGO, $this->message);
    }

    public function toArray(): array
    {
        return [
            'hash' => $this->sha1(),
            'message' => $this->message,
        ];
    }
}