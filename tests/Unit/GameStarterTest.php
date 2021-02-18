<?php

namespace Tests\Unit;

use FootballWorldCup\GameStarter;
use FootballWorldCup\Models\AwayTeam;
use FootballWorldCup\Models\Game;
use FootballWorldCup\Models\HomeTeam;
use FootballWorldCup\Models\ScoreBoard;
use FootballWorldCup\Interfaces\{IAwayTeam, IGameStarter, IHomeTeam, ITeam};
use Tests\TestCase;
use TypeError;

class GameStarterTest extends TestCase
{
    private function makeGameStarter(): GameStarter
    {
        return new GameStarter(new ScoreBoard);
    }

    public function testImplementGameStarterContract()
    {
        $this->assertInstanceOf(IGameStarter::class, $this->makeGameStarter());
    }

    public function testHomeTeamNullThrows()
    {
        $gameStarter = $this->makeGameStarter();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument 1 passed to FootballWorldCup\GameStarter::startGame()');
        $this->expectExceptionMessage('null given');

        $awayTeamMock = $this->getMockBuilder(IAwayTeam::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gameStarter->startGame(null, $awayTeamMock);
    }

    public function testAwayTeamNullThrows()
    {
        $gameStarter = $this->makeGameStarter();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument 2 passed to FootballWorldCup\GameStarter::startGame()');
        $this->expectExceptionMessage('null given');

        $homeTeamMock = $this->getMockBuilder(IHomeTeam::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gameStarter->startGame($homeTeamMock, null);
    }

    public function testAddGameContainsGame()
    {
        $gameStarter = $this->makeGameStarter();

        $homeTeam = new HomeTeam('Barcelona');
        $awayTeam = new AwayTeam('Madrid');

        $gameStarter->startGame($homeTeam, $awayTeam);

        $games = $gameStarter->getScoreBoard()->getGames();
        $this->assertCount(1, $games);
        $this->assertIsArray($games);
        $this->assertInstanceOf(Game::class, $games[0]);
    }

}
