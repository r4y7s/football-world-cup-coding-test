<?php
declare(strict_types=1);

namespace FootballWorldCup;

use FootballWorldCup\Interfaces\{IGame, IGameFinisher};
use FootballWorldCup\Models\ScoreBoard;

final class GameFinisher implements IGameFinisher
{
    private ScoreBoard $scoreBoard;

    public function __construct(ScoreBoard $scoreBoard)
    {
        $this->scoreBoard = $scoreBoard;
    }

    public function finishGame(IGame $game)
    {
        $this->scoreBoard->removeGame($game);
    }
}
