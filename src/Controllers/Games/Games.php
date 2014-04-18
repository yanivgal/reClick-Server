<?php

namespace reClick\Controllers\Games;

use reClick\Models\Games\GamesModel;

class Games {

    public function __construct() {
        $this->model = new GamesModel();
    }

    /**
     * @return Game
     */
    public function create() {
        return new Game($this->model->create());
    }

    /**
     * @return array
     */
    public function getAllOpenGames() {
        return $this->model->getAllOpenGames();
    }

} 