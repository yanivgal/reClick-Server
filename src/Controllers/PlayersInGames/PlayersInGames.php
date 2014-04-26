<?php

namespace reClick\Controllers\PlayersInGames;

use reClick\Controllers\Games\Game;
use reClick\Models\PlayersInGames\PlayersInGamesModel;

class PlayersInGames {

    /**
     * @var \reClick\Models\PlayersInGames\PlayersInGamesModel
     */
    private $model;

    public function __construct() {
        $this->model = new PlayersInGamesModel();
    }

    /**
     * @param int $playerId
     * @param int $gameId
     */
    public function addPlayerToGame($playerId, $gameId) {
        $this->model->addPlayerToGame($playerId, $gameId);
    }

    /**
     * @param int $playerId
     * @param int $gameId
     */
    public function playerConfirmed($playerId, $gameId) {
        $this->model->setTurn(
            $playerId,
            $gameId,
            $this->getNewTurnNum($gameId)
        );
        $this->model->setConfirmed($playerId, $gameId);
    }

    /**
     * @param int $playerId
     * @param int $gameId
     * @return string
     */
    public function getConfirmation($playerId, $gameId) {
        return $this->model->getConfirmation($playerId, $gameId);
    }

    /**
     * @param int $playerId
     * @param int $gameId
     */
    public function removePlayer($playerId, $gameId) {
        $this->model->removePlayerFromGame($playerId, $gameId);
    }

    /**
     * @param int $gameId
     */
    public function removeNotConfirmedPlayers($gameId) {
        $players = $this->players($gameId);
        foreach ($players as $player) {
            if (!$player['confirmed']) {
                $this->removePlayer($player['id'], $gameId);
            }
        }
    }

    /**
     * @param int $gameId
     * @param int $removedTurn
     */
    public function updateTurns($gameId, $removedTurn) {
        $this->model->updateTurns($gameId, $removedTurn);
    }

    /**
     * @param int $playerId
     * @return array
     */
    public function games($playerId) {
        $gamesId = $this->model->games($playerId);
        $games = [];
        foreach ($gamesId as $gameId) {
            $game = new Game($gameId['id']);
            $games[] = $game->toArray();
        }
        return $games;
    }

    /**
     * @param int $gameId
     * @return array
     */
    public function players($gameId) {
        return $this->model->players($gameId);
    }

    /**
     * @param int $gameId
     * @return string
     */
    private function getNewTurnNum($gameId) {
        $lastInLine = $this->model->getLastInLine($gameId);
        return empty($lastInLine) ? 1 : (int) $lastInLine + 1;
    }
}