<?php
declare(strict_types=1);

namespace PhpGeeks\Minesweeper\Test;

use PhpGeeks\Minesweeper\Board;
use PhpGeeks\Minesweeper\BombMap;
use PhpGeeks\Minesweeper\Game;
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
                [],
            ],
            [
                [''],
            ],
        ];
    }

    /** @test */
    public function canCreateGame()
    {
        $board = $this->createGame([
            '*',
        ]);
        $this->assertFalse($board->isLost());
        $this->assertEquals(
            [
                [Board::UNOPENED_CELL],
            ],
            $board->getView()
        );
    }

    /** @test */
    public function gameIsLostWhenBombIsClicked()
    {
        $game = $this->createGame([
            '*',
        ]);
        $game->click(0, 0);
        $this->assertTrue($game->isLost());
        $this->assertView(
            [
                'x',
            ],
            $game
        );
    }

    /** @test */
    public function gameIsWonWhenAllNonBombsAreOpen()
    {
        $game = $this->createGame([
            ' *',
            '  ',
        ]);
        $game->click(0, 0);
        $this->assertFalse($game->isWon());
        $this->assertView(
            [
                '1 ',
                '  ',
            ],
            $game
        );
        $game->click(1, 0);
        $this->assertFalse($game->isWon());
        $this->assertView(
            [
                '1 ',
                '1 ',
            ],
            $game
        );
        $game->click(1, 1);
        $this->assertTrue($game->isWon());
        $this->assertView(
            [
                '1 ',
                '11',
            ],
            $game
        );
    }

    /**
     * @test
     */
    public function maximumBombNumberIsReachable()
    {
        $game = $this->createGame([
            '***',
            '* *',
            '***',
        ]);
        $game->click(1, 1);
        $this->assertTrue($game->isWon());
        $this->assertView(
            [
                '   ',
                ' 8 ',
                '   ',
            ],
            $game
        );

    }

    private function createGame(array $map): Game
    {
        return new Game(
            new BombMap(
                $this->stringsToArray($map)
            )
        );
    }

    private function assertView(array $view, Game $game): void
    {
        $this->assertEquals(
            $this->stringsToArray($view),
            $game->getView()
        );
    }

    private function stringsToArray(array $strings): array
    {
        return array_map(
            function (string $s) {
                return $s ? str_split($s) : [];
            },
            $strings
        );
    }
}
