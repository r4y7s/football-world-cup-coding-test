<?php
declare(strict_types=1);

namespace FootballWorldCup;

use FootballWorldCup\Interfaces\{IAwayTeam, IHomeTeam, IGameStarter};
use FootballWorldCup\Models\{Game, ScoreBoard};

final class GameStarter implements IGameStarter
{
    private ScoreBoard $scoreBoard;

    public function __construct(ScoreBoard $scoreBoard)
    {
        $this->scoreBoard = $scoreBoard;
    }

    public function startGame(IHomeTeam $homeTeam, IAwayTeam $awayTeam)
    {
        $game = new Game(
            $this->generateGameId(),
            $homeTeam,
            $awayTeam,
        );
        $this->scoreBoard->addGame($game);
    }

    public function getScoreBoard(): ScoreBoard
    {
        return $this->scoreBoard;
    }

    private function generateGameId(): int
    {
        return $this->scoreBoard->numOfGames() + 1;
    }
}
