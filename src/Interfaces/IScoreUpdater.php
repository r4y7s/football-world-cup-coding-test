<?php

namespace FootballWorldCup\Interfaces;

interface IScoreUpdater
{
    public function updateScore(IGame $game, ?int $scoreHomeTeam=null, ?int $scoreAwayTeam=null): void;
}
