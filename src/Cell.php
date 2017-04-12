<?php
declare(strict_types=1);

namespace PhpGeeks\Minesweeper;

class Cell
{
    private $row;
    private $col;

    public function __construct(int $row, int $col)
    {
        $this->row = $row;
        $this->col = $col;
    }

    public static function iterateRectangle(int $width, int $height): \Iterator
    {
        for ($r = 0; $r < $width; $r++) {
            for ($c = 0; $c < $height; $c++) {
                yield new Cell($r, $c);
            }
        }
    }

    public function inArray(array $a)
    {
        return $a[$this->row][$this->col];
    }

    public function setInArray(array &$a, $value): void
    {
        $a[$this->row][$this->col] = $value;
    }

    public function getNeighbors(int $width, int $height): \Iterator
    {
        foreach ($this->getAdjacent($this->row, $height) as $r) {
            foreach ($this->getAdjacent($this->col, $width) as $c) {
                yield new Cell($r, $c);
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
}
