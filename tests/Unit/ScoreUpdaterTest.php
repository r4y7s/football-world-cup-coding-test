<?php

namespace Tests\Unit;

use FootballWorldCup\Interfaces\IScoreUpdater;
use FootballWorldCup\Models\{AwayTeam, Game ,HomeTeam ,Score , ScoreBoard};
use FootballWorldCup\ScoreUpdater;
use Tests\TestCase;

class ScoreUpdaterTest extends TestCase
{
    private function makeScoreBoard(): ScoreBoard
    {
        $scoreBoard = new ScoreBoard();

        $scoreBoard->addGame(
            new Game(
                1,
                new HomeTeam('Barcelona'),
                new AwayTeam('Sevilla'),
                (new Score)->setAwayScore(1)->setHomeScore(3)
            )
        );
        $scoreBoard->addGame(
            new Game(
                2,
                new HomeTeam('Madrid'),
                new AwayTeam('Valencia'),
                (new Score)->setAwayScore(0)->setHomeScore(1)
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

    public function testImplementScoreUpdaterContract()
    {
        $this->assertInstanceOf(IScoreUpdater::class, new ScoreUpdater($this->makeScoreBoard()));
    }

    /**
     * @param int $homeScore
     * @param int $expected
     *
     * @testWith [5, 5]
     *           [3, 3]
     *           [0, 0]
     * @testdox Update homeScore to $homeScore and value expected is $expected
     */
    public function testScoreHomeAndScoreAwayIncrementHomeScore(int $homeScore, int $expected)
    {
        $scoreBoard = $this->makeScoreBoard();

        $game = new Game(
            1,
            new HomeTeam('Barcelona'),
            new AwayTeam('Sevilla')
        );

        $scoreUpdater = new ScoreUpdater($scoreBoard);
        $scoreUpdater->updateScore($game, $homeScore);

        $this->assertEquals($expected, $scoreBoard->getGames()[0]->getScore()->getHomeScore());
        $this->assertEquals(1, $scoreBoard->getGames()[0]->getScore()->getAwayScore());
    }

    /**
     * @param int $awayScore
     * @param int $expected
     *
     * @testWith [2, 2]
     *           [0, 0]
     *           [3, 3]
     * @testdox Update awayScore to $awayScore and value expected is $expected
     */
    public function testScoreHomeAndScoreAwayIncrementAwayScore(int $awayScore, int $expected)
    {
        $scoreBoard = $this->makeScoreBoard();

        $game = new Game(
            1,
            new HomeTeam('Barcelona'),
            new AwayTeam('Sevilla')
        );

        $scoreUpdater = new ScoreUpdater($scoreBoard);
        $scoreUpdater->updateScore($game, null, $awayScore);

        $this->assertEquals($expected, $scoreBoard->getGames()[0]->getScore()->getAwayScore());
        $this->assertEquals(3, $scoreBoard->getGames()[0]->getScore()->getHomeScore());
    }

    /**
     * @param int $homeScore
     * @param int $awayScore
     * @param int $expected
     *
     * @testWith [5, 1, 6]
     *           [3, 0, 3]
     *           [0, 0, 0]
     * @testdox Update homeScore to $homeScore, awayScore to $awayScore and total expected is $expected
     */
    public function testScoreHomeAndScoreAwayIncrementTotalScore(int $homeScore, int $awayScore, int $expected)
    {
        $scoreBoard = $this->makeScoreBoard();

        $game = new Game(
            1,
            new HomeTeam('Barcelona'),
            new AwayTeam('Sevilla')
        );

        $scoreUpdater = new ScoreUpdater($scoreBoard);
        $scoreUpdater->updateScore($game, $homeScore, $awayScore);

        $this->assertEquals($expected, $scoreBoard->getGames()[0]->getScore()->getTotalScore());
    }
}
