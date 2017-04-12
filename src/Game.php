<?php
declare(strict_types=1);

namespace PhpGeeks\Minesweeper;

class Game
{
    /**
     * @var BombMap
     */
    private $map;

    /**
     * @var Board
     */
    private $board;

    private $is_lost = false;

    public function __construct(BombMap $bomb_map)
    {
        $this->map = $bomb_map;
        $this->board = new Board(
            $bomb_map->getWidth(),
            $bomb_map->getHeight()
        );
    }

    public function click(int $row, int $col): void
    {
        $cell = new Cell($row, $col);
        if ($this->map->hasBomb($cell)) {
            $this->markGameLost();
        } else {
            $this->board->drawNumber(
                $this->map->countBombsAround($cell),
                $cell
            );
        }
    }

    public function isLost(): bool
    {
        return $this->is_lost;
    }

    public function isWon(): bool
    {
        foreach ($this->board->getCells() as $cell) {
            if (
                !$this->board->isOpen($cell)
                && !$this->map->hasBomb($cell)
            ) {
                return false;
            }
        };
        return true;
    }

    public function getView(): array
    {
        return $this->board->getView();
    }

    private function markGameLost(): void
    {
        $this->is_lost = true;
        foreach ($this->map->getBombCells() as $cell) {
            $this->board->drawBomb($cell);
        }
    }
}
