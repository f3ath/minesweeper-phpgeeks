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

    public function hasBomb(Cell $point): bool
    {
        return self::BOMB === $point->inArray($this->map);
    }

    public function countBombsAround(Cell $cell): int
    {
        $count = 0;
        foreach ($cell->getNeighbors($this->getWidth(), $this->getHeight()) as $neighbor) {
            if ($this->hasBomb($neighbor)) {
                $count++;
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
        foreach (Cell::iterateRectangle($this->getWidth(), $this->getHeight()) as $cell) {
            if ($this->hasBomb($cell)) {
                yield $cell;
            }
        }
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
