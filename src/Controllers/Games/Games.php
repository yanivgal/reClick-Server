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
    public function getOpenGames() {
        $games = $this->model->getOpenGames();
        foreach ($games as $i => $game) {
            $games[$i] = (new Game($game['id']))->toArray();
        }
        return $games;
    }
} 