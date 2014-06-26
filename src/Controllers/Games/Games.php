<?php

namespace reClick\Controllers\Games;

use reClick\Models\Games\GamesModel;

class Games {

    public function __construct() {
        $this->model = new GamesModel();
    }

    /**
     * @param string $name
     * @param string $description
     * @return Game
     */
    public function create($name = null, $description = null) {
        $name = isset($name) ? $name : $this->randGameName();
        $description = isset($description) ? $description : 'Best game ever';

        return new Game($this->model->create($name, $description));
    }

    /**
     * @return array
     */
    public function getAllGames() {
        $games = $this->model->getAllGames();
        foreach ($games as $i => $game) {
            $games[$i] = (new Game($game['id']))->toArray();
        }
        return $games;
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

    /**
     * @param int $playerId
     * @return array
     */
    public function getOpenGamesBut($playerId) {
        $games = $this->model->getOpenGamesBut($playerId);
        foreach ($games as $i => $game) {
            $games[$i] = (new Game($game['id']))->toArray();
        }
        return $games;
    }

    /**
     * @return int
     */
    public function deleteAllGames() {
        return $this->model->deleteAllGames();
    }

    /**
     * @return string
     */
    private function randGameName() {
        return 'Game' . rand(100000, 1000000);
    }
} 