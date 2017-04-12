<?php
declare(strict_types=1);

namespace PhpGeeks\Minesweeper;

use SebastianBergmann\CodeCoverage\Node\Iterator;

class Board
{
    public const UNOPENED_CELL = ' ';
    public const BOMB_CELL = 'x';

    private $view;
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    public function __construct(int $width, int $height)
    {
        $this->view = array_fill(
            0,
            $height,
            array_fill(0, $width, self::UNOPENED_CELL)
        );
        $this->width = $width;
        $this->height = $height;
    }

    public function getView(): array
    {
        return $this->view;
    }

    public function drawBomb(Cell $point): void
    {
        $point->setInArray($this->view, self::BOMB_CELL);
    }

    public function drawNumber(int $number, Cell $point): void
    {
        $point->setInArray($this->view, (string) $number);
    }

    public function isOpen(Cell $point): bool
    {
        return $point->inArray($this->view) !== self::UNOPENED_CELL;
    }

    public function getCells(): \Iterator
    {
        for ($r = 0; $r < $this->width; $r++) {
            for ($c = 0; $c < $this->height; $c++) {
                yield new Cell($r, $c);
            }
        }
    }
}
