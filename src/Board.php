<?php
declare(strict_types=1);

namespace PhpGeeks\Minesweeper;

class Board
{
    public const UNOPENED_CELL = ' ';
    public const BOMB_CELL = 'x';

    private $view;

    public function __construct(int $with, int $height)
    {
        $this->view = array_fill(
            0,
            $height,
            array_fill(0, $with, self::UNOPENED_CELL)
        );
    }

    public function getView(): array
    {
        return $this->view;
    }

    public function drawBomb(int $row, int $col): string
    {
        return $this->view[$row][$col] = self::BOMB_CELL;
    }

    public function drawNumber(int $number, int $row, int $col)
    {
        return $this->view[$row][$col] = (string) $number;
    }
}
