<?php

namespace Tests\Unit;

use FootballWorldCup\Exceptions\GameNotFound;
use FootballWorldCup\GameFinisher;
use FootballWorldCup\Models\{AwayTeam, Game, HomeTeam, ScoreBoard};
use FootballWorldCup\Interfaces\IGameFinisher;
use Tests\TestCase;

class GameFinisherTest extends TestCase
{
    private function makeScoreBoard(): ScoreBoard
    {
        $scoreBoard = new ScoreBoard();

        $scoreBoard->addGame(
            new Game(
                1,
                new HomeTeam('Barcelona'),
                new AwayTeam('Sevilla')
            )
        );
        $scoreBoard->addGame(
            new Game(
                2,
                new HomeTeam('Madrid'),
                new AwayTeam('Valencia')
            )
        );
        $scoreBoard->addGame(
            new Game(
                3,
                new HomeTeam('Betis'),
                new AwayTeam('Huesca')
            )
        );

        return  $scoreBoard;
    }

    public function testImplementGameFinisherContract()
    {
        $this->assertInstanceOf(IGameFinisher::class, new GameFinisher($this->makeScoreBoard()));
    }

    public function testFinishGameThrowGameNotFound()
    {
        $scoreBoard = $this->makeScoreBoard();
        $count = $scoreBoard->numOfGames();

        $gameToFinish = new Game(5, new HomeTeam('Granada'), new AwayTeam('Eibar'));
        $gameFinisher = new GameFinisher($scoreBoard);
        $this->expectException(GameNotFound::class);
        $this->expectExceptionMessage('Game not found in current score board');
        $gameFinisher->finishGame($gameToFinish);
        $this->assertEquals($count, $scoreBoard->numOfGames());
    }

    public function testDecreaseCountWhenFinishGame()
    {
        $scoreBoard = $this->makeScoreBoard();
        $count = $scoreBoard->numOfGames();

        $gameToFinish = new Game(3, new HomeTeam('Betis'), new AwayTeam('Huesca'));
        $gameFinisher = new GameFinisher($scoreBoard);
        $gameFinisher->finishGame($gameToFinish);

        $this->assertEquals($count-1, $scoreBoard->numOfGames());
    }
}
