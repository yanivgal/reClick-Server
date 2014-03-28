<?php

namespace reClick\Controllers\Games;

use reClick\Controllers\BaseController;
use reClick\Models\Games\GameModel;

class Game extends BaseController {

    /**
     * Constructor
     *
     * @param int $id GameModel's ID
     */
    public function __construct($id = null) {
        parent::__construct($id);
        $this->model = new GameModel();
    }

    /**
     * Creates a new game
     *
     * @return Game
     */
    public function create() {
        $this->id = $this->model->create();

        return $this;
    }

    /**
     * Returns the number of players in game
     *
     * @return string
     */
    public function numOfPlayers() {
        return $this->model->numOfPlayers($this->id);
    }

    /**
     * Gets Sets current game sequence<p>
     * Game sequence example:<p>
     * '1,3,2,3,4,1,1,2,3,4,2,3,1,1,3,2,4,4,3,4,2,3,4,4,1,2,3'
     *
     * @param string $sequence
     * @return int|string
     */
    public function sequence($sequence = null) {
        return $this->model->sequence($this->id, $sequence);
    }

    /**
     * Gets Sets game's turn number
     *
     * @param string|null $turn
     * @return int|string
     */
    public function turn($turn = null) {
        return $this->model->turn($this->id, $turn);
    }

    /**
     * Checks if game has started
     *
     * @return string
     */
    public function started() {
        return $this->model->started($this->id);
    }

    /**
     * Start the game
     *
     * @return int
     */
    public function start() {
        return $this->model->startGame($this->id);
    }

} 