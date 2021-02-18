<?php

namespace FootballWorldCup\Interfaces;

interface IGame
{
    public function getId(): int;
    public function getHomeTeam(): IHomeTeam;
    public function getAwayTeam(): IAwayTeam;
    public function getScore();
}
