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
        $currTurn = $this->model->getCurrTurn($gameId);
        $newTurn = empty($currTurn) ?
            PlayerInGameModel::FIRST_PLAYER_TURN : $currTurn + 1;
        $isFirst = $newTurn == PlayerInGameModel::FIRST_PLAYER_TURN ?
            PlayerInGameModel::FIRST_PLAYER_TURN :
            PlayerInGameModel::NOT_FIRST_PLAYER;
        $this->model->addPlayerToGame($playerId, $gameId, $newTurn, $isFirst);
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
}