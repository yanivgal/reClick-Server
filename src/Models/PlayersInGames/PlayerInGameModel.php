<?php

namespace reClick\Models\PlayersInGames;

use reClick\Models\BaseModel;

class PlayerInGameModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'players_in_games';
    }

    /**
     * @param int $playerId
     * @param int $gameId
     * @param int $newTurn
     * @param int $isFirstPlayer
     */
    public function addPlayerToGame(
        $playerId,
        $gameId,
        $newTurn,
        $isFirstPlayer = 0
    ) {
        $this->db->insert(
            $this->table,
            [
                'player_id' => $playerId,
                'game_id' => $gameId,
                'approved' => $isFirstPlayer,
                'turn' => $newTurn
            ]
        );
    }

    /**
     * @param int $gameId
     * @return string
     */
    public function getCurrTurn($gameId) {
        return $this->db->select(
            $this->table,
            ['max(turn) as max_turn'],
            ['game_id' => $gameId]
        )->fetchValue();
    }

    /**
     * @param int $playerId
     * @param int $gameId
     */
    public function deletePlayerFromGame($playerId, $gameId) {
        $this->db->delete(
            $this->table,
            [
                'player_id' => $playerId,
                'game_id' => $gameId
            ]
        );
    }

    /**
     * @param int $playerId
     * @param int $gameId
     * @param int $turn
     */
    public function updateTurn($playerId, $gameId, $turn) {
        $this->db->update(
            $this->table,
            ['turn' => $turn],
            [
                'player_id' => $playerId,
                'game-id' => $gameId
            ]
        );
    }
}