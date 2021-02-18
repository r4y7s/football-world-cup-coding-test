<?php
declare(strict_types=1);

namespace FootballWorldCup\Models;

use FootballWorldCup\Interfaces\{IAwayTeam, IGame, IHomeTeam};

final class Game implements IGame
{
    private int $id;
    private IHomeTeam $homeTeam;
    private IAwayTeam $awayTeam;
    private Score $score;

    public function __construct(int $id, IHomeTeam $homeTeam, IAwayTeam $awayTeam, ?Score $score=null)
    {
        $this->id = $id;
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->score = $score ?? new Score();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHomeTeam(): IHomeTeam
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): IAwayTeam
    {
        return $this->awayTeam;
    }

    public function getScore(): Score
    {
        return $this->score;
    }
}
