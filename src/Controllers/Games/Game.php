<?php

namespace reClick\Controllers\Games;

use reClick\Controllers\BaseController;
use reClick\Models\Games\GameModel;

class Game extends BaseController {

    /**
     * @param int $id Game ID
     */
    public function __construct($id = null) {
        parent::__construct($id);
        $this->model = new GameModel();
    }

    /**
     * @return Game
     */
    public function create() {
        $this->id = $this->model->create();

        return $this;
    }

    /**
     * @return string
     */
    public function numOfPlayers() {
        return $this->model->numOfPlayers($this->id);
    }

    /**
     * @param string $sequence
     * @return int|string
     */
    public function sequence($sequence = null) {
        return $this->model->sequence($this->id, $sequence);
    }

    /**
     * @param string|null $turn
     * @return int|string
     */
    public function turn($turn = null) {
        return $this->model->turn($this->id, $turn);
    }

    /**
     * @return string
     */
    public function started() {
        return $this->model->started($this->id);
    }

    /**
     * @return int
     */
    public function start() {
        return $this->model->startGame($this->id);
    }
} 