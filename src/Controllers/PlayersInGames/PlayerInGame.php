<?php

namespace reClick\Controllers\PlayersInGames;

use reClick\Controllers\BaseController;
use reClick\Models\PlayersInGames\PlayerInGameModel;
use reClick\Framework\Db;

class PlayerInGame extends BaseController {

    /**
     * @param int $id PlayerInGame ID
     */
    public function __construct($id = null) {
        parent::__construct($id);
        $this->model = new PlayerInGameModel;
    }

    /**
     * @param int $playerId
     * @param int $gameId
     */
    public function addPlayer($playerId, $gameId) {
        $currTurn = $this->model->getCurrTurn($gameId);
        $newTurn = empty($temp) ? 1 : $currTurn + 1;
        $isFirst = $newTurn == 1 ? 1 : 0;
        $this->model->addPlayerToGame($playerId, $gameId, $newTurn, $isFirst);
    }

    /**
     * @param int $playerId
     * @param int $gameId
     */
    public function deletePlayer($playerId, $gameId) {
        $this->model->deletePlayerFromGame($playerId, $gameId);
    }

    private function updateTurns($gameId, $removedTurn) {
        $db = new Db();
        $db->query(
            'UPDATE players_in_games
             SET    turn = turn - 1
             WHERE  game_id = ?
                    AND turn > ?',
            [$gameId, $removedTurn]
        );
    }
}