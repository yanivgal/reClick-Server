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
     * @return string
     */
    public function getPlayerTurn($playerId, $gameId) {
        return $this->db->select(
            $this->table,
            ['turn'],
            ['player_id' => $playerId, 'game_id' => $gameId]
        )->fetchValue();
    }

    /**
     * @param int $playerId
     * @param int $gameId
     */
    public function removePlayerFromGame($playerId, $gameId) {
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
        $this->db->query(
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
     * @param int $playerId
     * @return array
     */
    public function games($playerId) {
        return $this->db->select(
            $this->table,
            ['game_id as id'],
            ['player_id' => $playerId]
        )->fetchAll();
    }

    /**
     * @param int $gameId
     * @return array
     */
    public function players($gameId) {
        return $this->db->query(
            'SELECT pg.player_id AS id,
                    p.nickname AS nickname,
                    p.location AS location,
                    pg.turn AS turn,
                    pg.confirmed as confirmed
             FROM   players_in_games pg
                    INNER JOIN players p
                            ON p.id = pg.player_id
             WHERE  game_id = ?',
            [$gameId]
        )->fetchAll();
//        return $this->db->select(
//            $this->table,
//            ['player_id as id', 'turn', 'confirmed'],
//            ['game_id' => $gameId]
//        )->fetchAll();
    }

    /**
     * @param int $gameId
     * @param int $turn
     * @return string
     */
    public function getPlayerByTurn($gameId, $turn) {
        return $this->db->select(
            $this->table,
            ['player_id as id'],
            ['game_id' => $gameId, 'turn' => $turn]
        )->fetchValue();
    }

    /**
     * @param int $gameId
     * @return string
     */
    public function getGameMaxTurn($gameId) {
        return $this->db->select(
            $this->table,
            ['max(turn) as turn'],
            ['game_id' => $gameId]
        )->fetchValue();

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