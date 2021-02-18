<?php
declare(strict_types=1);

namespace FootballWorldCup\Models;

use FootballWorldCup\Interfaces\ITeam;

abstract class TeamBase implements ITeam
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
