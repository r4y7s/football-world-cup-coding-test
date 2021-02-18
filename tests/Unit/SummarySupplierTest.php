<?php

namespace Tests\Unit;

use FootballWorldCup\Interfaces\ISummarySupplier;
use FootballWorldCup\Models\{AwayTeam, Game, HomeTeam, Score, ScoreBoard};
use FootballWorldCup\SummarySupplier;
use Tests\TestCase;

class SummarySupplierTest extends TestCase
{
    private function makeScoreBoard(): ScoreBoard
    {
        $scoreBoard = new ScoreBoard();

        $scoreBoard->addGame(
            new Game(
                1,
                new HomeTeam('Mexico'),
                new AwayTeam('Canada'),
                (new Score)->setAwayScore(0)->setHomeScore(5)
            )
        );
        $scoreBoard->addGame(
            new Game(
                2,
                new HomeTeam('Spain'),
                new AwayTeam('Brazil'),
                (new Score)->setAwayScore(10)->setHomeScore(2)
            )
        );
        $scoreBoard->addGame(
            new Game(
                3,
                new HomeTeam('Germany'),
                new AwayTeam('France'),
                (new Score)->setAwayScore(2)->setHomeScore(2)
            )
        );
        $scoreBoard->addGame(
            new Game(
                4,
                new HomeTeam('Uruguay'),
                new AwayTeam('Italy'),
                (new Score)->setAwayScore(6)->setHomeScore(6)
            )
        );
        $scoreBoard->addGame(
            new Game(
                5,
                new HomeTeam('Argentina'),
                new AwayTeam('Australia'),
                (new Score)->setAwayScore(3)->setHomeScore(1)
            )
        );

        return  $scoreBoard;
    }

    public function testImplementScoreUpdaterContract()
    {
        $this->assertInstanceOf(ISummarySupplier::class, new SummarySupplier(new ScoreBoard));
    }

    public function testGetSummaryIsArrayOfGame()
    {
        $summarySupplier = new SummarySupplier($this->makeScoreBoard());

        $summary=$summarySupplier->getSummary();
        $this->assertCount(5, $summary);
        $this->assertInstanceOf(Game::class, $summary[0]);
    }

    public function testSummaryCorrectOrder()
    {
        $summarySupplier = new SummarySupplier($this->makeScoreBoard());

        $summary=$summarySupplier->getSummary();
        $this->assertCount(5, $summary);

        foreach ([4, 2, 1, 5, 3] as $key=>$id){
            $this->assertEquals($id, $summary[$key]->getId());
        }
    }

    public function testZeroTotalScoreCorrectOrder()
    {
        $scoreBoard = new ScoreBoard();
        $scoreBoard->addGame(
            new Game(
                1,
                new HomeTeam('Mexico'),
                new AwayTeam('Canada')
            )
        );
        $scoreBoard->addGame(
            new Game(
                2,
                new HomeTeam('Argentina'),
                new AwayTeam('Australia')
            )
        );
        $summarySupplier = new SummarySupplier($scoreBoard);

        $summary=$summarySupplier->getSummary();
        $this->assertCount(2, $summary);

        foreach ([2, 1] as $key=>$id){
            $this->assertEquals($id, $summary[$key]->getId());
        }
    }

}
