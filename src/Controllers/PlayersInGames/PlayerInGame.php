<?php

namespace reClick\Controllers\PlayersInGames;

use reClick\Models\PlayersInGames\PlayerInGameModel;

class PlayerInGame {

    /**
     * @var \reClick\Models\PlayersInGames\PlayerInGameModel
     */
    private $model;

    public function __construct() {
        $this->model = new PlayerInGameModel();
    }

    /**
     * @param int $playerId
     * @param int $gameId
     */
    public function addPlayer($playerId, $gameId) {
        $newTurn = $this->getNewTurnNum($gameId);
        $isFirst = $newTurn == PlayerInGameModel::FIRST_PLAYER_TURN ?
            PlayerInGameModel::FIRST_PLAYER_TURN :
            PlayerInGameModel::NOT_FIRST_PLAYER;
        $this->model->addPlayerToGame($playerId, $gameId, $newTurn, $isFirst);
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
     * @return string
     */
    private function getNewTurnNum($gameId) {
        $lastInLine = $this->model->getLastInLine($gameId);
        return empty($lastInLine) ?
            PlayerInGameModel::FIRST_PLAYER_TURN : $lastInLine + 1;
    }
}