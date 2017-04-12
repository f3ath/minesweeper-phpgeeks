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
        if ($this->map->hasBomb($row, $col)) {
            $this->is_lost = true;
            $this->updateView();
        } else {
            $this->board->drawNumber(
                $this->map->countBombsAround($row, $col),
                $row,
                $col
            );
        }
    }

    public function isLost(): bool
    {
        return $this->is_lost;
    }

    public function isWon(): bool
    {
        return true;
    }

    public function getView(): array
    {
        return $this->board->getView();
    }

    private function updateView(): void
    {
        foreach ($this->map->getBombCells() as $cell) {
            $this->board->drawBomb(...$cell);
        }
    }
}
