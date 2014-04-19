<?php

namespace reClick\Models\PlayersInGames;

use reClick\Framework\Db;
use reClick\Models\BaseModel;

class PlayersInGamesModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'players_in_games';
    }

    /**
     * @param int $playerId
     * @param int $gameId
     */
    public function addPlayerToGame($playerId, $gameId) {
        $this->db->insert(
            $this->table,
            ['player_id' => $playerId, 'game_id' => $gameId]
        );
    }

    /**
     * @param int $playerId
     * @param int $gameId
     * @return int
     */
    public function setConfirmed($playerId, $gameId) {
        return $this->db->update(
            $this->table,
            ['confirmed' => 1],
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
     * @return int
     */
    public function setTurn($playerId, $gameId, $turn) {
        return $this->db->update(
            $this->table,
            ['turn' => $turn],
            [
                'player_id' => $playerId,
                'game_id' => $gameId
            ]
        );
    }

    /**
     * @param int $gameId
     * @return string
     */
    public function getLastInLine($gameId) {
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
     * @param int $gameId
     * @param int $removedTurn
     */
    public function updateTurns($gameId, $removedTurn) {
        $db = new Db();
        $db->query(
            'UPDATE players_in_games
             SET    turn = turn - 1
             WHERE  game_id = ?
                    AND turn > ?',
            [$gameId, $removedTurn]
        );
    }

    /**
     * @param int $playerId
     * @param int $gameId
     * @param int $turn
     */
    public function updatePlayerTurn($playerId, $gameId, $turn) {
        $this->db->update(
            $this->table,
            ['turn' => $turn],
            [
                'player_id' => $playerId,
                'game_id' => $gameId
            ]
        );
    }

    /**
     * @param int $gameId
     * @return array
     */
    public function players($gameId) {
        return $this->db->select(
            $this->table,
            ['player_id as id', 'turn', 'confirmed'],
            ['game_id' => $gameId]
        )->fetchAll();
    }

    /**
     * @param int $playerId
     * @param int $gameId
     * @return string
     */
    public function getConfirmation($playerId, $gameId) {
        return $this->db->select(
            $this->table,
            ['confirmed'],
            ['player_id' => $playerId, 'game_id' => $gameId]
        )->fetchValue();
    }
}