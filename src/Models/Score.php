<?php
declare(strict_types=1);

namespace FootballWorldCup\Models;

final class Score
{
    private int $homeScore=0;
    private int $awayScore=0;

    public function getHomeScore(): int
    {
        return $this->homeScore;
    }

    public function setHomeScore(int $homeScore): self
    {
        $this->homeScore = $homeScore;
        return $this;
    }

    public function getAwayScore(): int
    {
        return $this->awayScore;
    }

    public function setAwayScore(int $awayScore): self
    {
        $this->awayScore = $awayScore;
        return $this;
    }

    public function getTotalScore(): int
    {
        return $this->getHomeScore() + $this->getAwayScore();
    }
}
