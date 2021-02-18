<?php
declare(strict_types=1);

namespace FootballWorldCup\Models;

use FootballWorldCup\Exceptions\GameNotFound;

final class ScoreBoard
{
    /**
     * @var Game[]
     */
    private array $games = [];

    /**
     * @return Game[]
     */
    public function getGames(): array
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        $this->games[] = $game;
        return $this;
    }

    public function removeGame(Game $game): self
    {
        unset($this->games[$this->findGameIndexById($game->getId())]);
        return $this;
    }

    public function getGameFromScoreBoard(Game $game): Game
    {
        return $this->games[$this->findGameIndexById($game->getId())];
    }

    public function numOfGames(): int
    {
        return count($this->games);
    }

    public function findGameIndexById(int $id): int
    {
        foreach($this->getGames() as $key=>$currentGame)
        {
            if($currentGame->getId() === $id)
                return $key;
        }

        throw new GameNotFound('Game not found in current score board');
    }
}
