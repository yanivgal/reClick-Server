<?php

namespace reClick\Models\Games;

use reClick\Models\BaseModel;

class GameModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'games';
    }

    /**
     * @return int
     */
    public function create() {
        return $this->db->insert(
            $this->table,
            []
        );
    }

    /**
     * @param int $id
     * @return string
     */
    public function numOfPlayers($id) {
        return $this->getOne($id, 'num_of_players');
    }

    /**
     * @param int $id
     * @param string|null $sequence
     * @return mixed
     */
    public function sequence($id, $sequence = null) {
        return $this->getSet($id, 'sequence', $sequence);
    }

    /**
     * @param int $id
     * @param string|null $turn
     * @return mixed
     */
    public function turn($id, $turn = null) {
        return $this->getSet($id, 'turn', $turn);
    }

    /**
     * @param int $id
     * @return string
     */
    public function started($id) {
        return $this->getOne($id, 'started');
    }

    /**
     * @param int $id
     * @return int
     */
    public function start($id) {
        return $this->setOne($id, 'start', 1);
    }
} 