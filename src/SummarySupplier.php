<?php
declare(strict_types=1);

namespace FootballWorldCup;

use FootballWorldCup\Interfaces\ISummarySupplier;
use FootballWorldCup\Models\{Game, ScoreBoard};

final class SummarySupplier implements ISummarySupplier
{
    private ScoreBoard $scoreBoard;

    public function __construct(ScoreBoard $scoreBoard)
    {
        $this->scoreBoard = $scoreBoard;
    }

    /**
     * @return Game[]
     */
    public function getSummary(): array
    {
        return $this->getGamesOrderByTotalScore();
    }

    private function getGamesOrderByTotalScore(): array
    {
        $gameList = $this->scoreBoard->getGames();

        usort($gameList, function (Game $gameA, Game $gameB){
            $scoreA = $gameA->getScore()->getTotalScore();
            $scoreB = $gameB->getScore()->getTotalScore();

            if($scoreA === $scoreB){
                return $gameA->getId() < $gameB->getId() ? 1 : -1;
            }

            return $scoreA < $scoreB ? 1 : -1;
        });

        return $gameList;
    }
}
