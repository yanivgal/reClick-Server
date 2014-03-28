<?php

namespace reClick\Models\Games;

use reClick\Models\BaseModel;

class GameModel extends BaseModel {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->table = 'games';
    }

    /**
     * Creates a new game
     *
     * @return int
     */
    public function create() {
        return $this->db->insert(
            $this->table,
            []
        );
    }

    /**
     * Returns the number of players in game
     *
     * @param int $id
     * @return string
     */
    public function numOfPlayers($id) {
        return $this->getOne($id, 'num_of_players');
    }

    /**
     * Gets Sets current game sequence<p>
     * Game sequence example:<p>
     * '1,3,2,3,4,1,1,2,3,4,2,3,1,1,3,2,4,4,3,4,2,3,4,4,1,2,3'
     *
     * @param int $id
     * @param string|null $sequence
     * @return mixed
     */
    public function sequence($id, $sequence = null) {
        return $this->getSet($id, 'sequence', $sequence);
    }

    /**
     * Gets Sets game's turn number
     *
     * @param int $id
     * @param string|null $turn
     * @return mixed
     */
    public function turn($id, $turn = null) {
        return $this->getSet($id, 'turn', $turn);
    }

    /**
     * Checks if game has started
     *
     * @param int $id
     * @return string
     */
    public function started($id) {
        return $this->getOne($id, 'started');
    }

    /**
     * Start the game
     *
     * @param int $id
     * @return int
     */
    public function start($id) {
        return $this->setOne($id, 'start', 1);
    }
} 