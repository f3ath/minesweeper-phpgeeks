<?php
declare(strict_types=1);

namespace PhpGeeks\Minesweeper;

class BombMap
{
    const BOMB = '*';
    const EMPTY = ' ';

    private $map;

    public function __construct(array $map)
    {
        if (!$this->isValid($map)) {
            throw new \InvalidArgumentException();
        }
        $this->map = $map;
    }

    public function hasBomb(int $row, int $col): bool
    {
        return self::BOMB === $this->map[$row][$col];
    }

    public function countBombsAround(int $row, int $col): int
    {
        $count = 0;
        foreach ($this->getAdjacent($row, $this->getHeight()) as $r) {
            foreach ($this->getAdjacent($col, $this->getWidth()) as $c) {
                if ($this->hasBomb($r, $c)) {
                    $count++;
                }
            }
        }
        return $count;
    }

    public function getWidth(): int
    {
        return count($this->map[0]);
    }

    public function getHeight(): int
    {
        return count($this->map);
    }

    public function getBombCells(): \Iterator
    {
        for ($r = 0; $r < $this->getWidth(); $r++) {
            for ($c = 0; $c < $this->getHeight(); $c++) {
                if ($this->hasBomb($r, $c)) {
                    yield [$r, $c];
                }
            }
        }
    }

    private function getAdjacent(int $n, int $size): array
    {
       return range(
           max(0, $n - 1),
           min($size - 1, $n + 1)
       );
    }

    private function isValid(array $map): bool
    {
        if (empty($map)) {
            return false;
        }
        foreach ($map as $row) {
            if (empty($row)) {
                return false;
            }
        }
        return true;
    }
}
