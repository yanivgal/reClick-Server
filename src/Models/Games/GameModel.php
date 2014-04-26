<?php

namespace reClick\Models\Games;

use reClick\Models\BaseModel;

class GameModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'games';
    }

    /**
     * @param int $id
     * @param string $name
     * @return string
     */
    public function name($id, $name = null) {
        return $this->getSet($id, 'name', $name);
    }

    /**
     * @param int $id
     * @param string $description
     * @return string
     */
    public function description($id, $description = null) {
        return $this->getSet($id, 'description', $description);
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
     * @param string $sequence
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
        return $this->setOne($id, 'started', 1);
    }

    /**
     * @param int $id
     * @return string
     */
    public function exists($id) {
        return $this->getOne($id, 'id');
    }

    /**
     * @param int $id
     * @return int
     */
    public function addPlayer($id) {
        return $this->setOne(
            $id,
            'num_of_players',
            (int) $this->numOfPlayers($id) + 1
        );
    }
} 