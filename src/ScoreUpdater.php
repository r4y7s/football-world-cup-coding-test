<?php
declare(strict_types=1);

namespace FootballWorldCup;

use FootballWorldCup\Interfaces\{IGame, IScoreUpdater};
use FootballWorldCup\Models\ScoreBoard;

final class ScoreUpdater implements IScoreUpdater
{
    private ScoreBoard $scoreBoard;

    public function __construct(ScoreBoard $scoreBoard)
    {
        $this->scoreBoard = $scoreBoard;
    }

    public function updateScore(IGame $game, ?int $scoreHomeTeam = null, ?int $scoreAwayTeam = null): void
    {
        $gameScore = $this->scoreBoard->getGameFromScoreBoard($game)->getScore();

        if( !is_null($scoreHomeTeam) ){
            $gameScore->setHomeScore($scoreHomeTeam);
        }
        if( !is_null($scoreAwayTeam) ){
            $gameScore->setAwayScore($scoreAwayTeam);
        }
    }
}
