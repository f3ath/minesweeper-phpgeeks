<?php
declare(strict_types=1);

namespace PhpGeeks\Minesweeper\Test;

use PhpGeeks\Minesweeper\Board;
use PhpGeeks\Minesweeper\Game;
use PhpGeeks\Minesweeper\BombMap;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidBoardProvider
     * @param array $board
     */
    public function canNotCreateEmptyBoard(array $board)
    {
        $this->createGame($board);
    }

    public function invalidBoardProvider(): array
    {
        return [
            [
                []
            ],
            [
                ['']
            ],
        ];
    }

    /** @test */
    public function canCreateGame()
    {
        $board = $this->createGame([
            '*'
        ]);
        $this->assertFalse($board->isLost());
        $this->assertEquals(
            [
                [Board::UNOPENED_CELL]
            ],
            $board->getView()
        );
    }

    /** @test */
    public function gameIsLostWhenBombIsClicked()
    {
        $game = $this->createGame([
            '*'
        ]);
        $game->click(0, 0);
        $this->assertTrue($game->isLost());
        $this->assertView(
            [
                'x'
            ],
            $game
        );
    }

    /** @test */
    public function gameIsWonWhenAllNonBombsAreOpen()
    {
        $game = $this->createGame([
            ' *',
        ]);
        $game->click(0, 0);
        $this->assertTrue($game->isWon());
        $this->assertView(
            [
                '1 ',
            ],
            $game
        );
    }

    private function createGame(array $map): Game
    {
        $map = array_map(
            function (string $s) { return $s ? str_split($s) : []; },
            $map
        );
        return new Game(new BombMap($map));
    }

    private function assertView(array $view, Game $game): void
    {
        $view = array_map(
            function (string $s) { return $s ? str_split($s) : []; },
            $view
        );
        $this->assertEquals($view, $game->getView());
    }
}
