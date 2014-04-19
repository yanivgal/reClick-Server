<?php

namespace reClick\Controllers\PlayersInGames;

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
    public function deletePlayer($playerId, $gameId) {
        $this->model->deletePlayerFromGame($playerId, $gameId);
    }

    /**
     * @param int $gameId
     * @param int $removedTurn
     */
    public function updateTurns($gameId, $removedTurn) {
        $this->model->updateTurns($gameId, $removedTurn);
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