<?php

namespace FootballWorldCup\Interfaces;

interface IGameStarter
{
    public function startGame(IHomeTeam $homeTeam, IAwayTeam $awayTeam);
}
