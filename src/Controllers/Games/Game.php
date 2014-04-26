<?php

namespace reClick\Controllers\Games;

use reClick\Controllers\BaseController;
use reClick\Controllers\PlayersInGames\PlayersInGames;
use reClick\Models\Games\GameModel;

class Game extends BaseController {

    /**
     * @var \reClick\Controllers\PlayersInGames\PlayersInGames
     */
    private $playersInGames;

    /**
     * @param int $id Game ID
     */
    public function __construct($id) {
        parent::__construct($id);
        $this->model = new GameModel();
        $this->playersInGames = new PlayersInGames();
    }

    /**
     * @param string $name
     * @return string|int
     */
    public function name($name = null) {
        return $this->model->name($this->id, $name);
    }

    /**
     * @param string $description
     * @return string|int
     */
    public function description($description = null) {
        return $this->model->description($this->id, $description);
    }

    /**
     * @return string
     */
    public function numOfPlayers() {
        return $this->model->numOfPlayers($this->id);
    }

    /**
     * @param string $sequence
     * @return string|int
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
     * @param string $name
     * @param string $description
     */
    public function updateInfo($name, $description) {
        if (isset($name)) {
            $this->model->name($this->id, $name);
        }
        if (isset($description)) {
            $this->model->description($this->id, $description);
        }
    }

    /**
     * @return bool
     */
    public function started() {
        $started = $this->model->started($this->id);
        if (!$started) {
            return false;
        }
        return true;
    }

    public function start() {
        $this->model->start($this->id);
        $this->turn(1);
        $this->playersInGames->removeNotConfirmedPlayers($this->id);
    }

    /**
     * @return bool
     */
    public function exists() {
        $s = $this->model->exists($this->id);
        if (empty($s)) {
            return false;
        }
        return true;
    }

    /**
     * @param int $playerId
     */
    public function addPlayer($playerId) {
        $this->playersInGames->addPlayerToGame($playerId, $this->id);
    }

    /**
     * @param int $playerId
     */
    public function playerConfirmed($playerId) {
        $this->playersInGames->playerConfirmed($playerId, $this->id);
        $this->model->addPlayer($this->id);
    }

    /**
     * @return array
     */
    public function players() {
        return $this->playersInGames->players($this->id);
    }

    /**
     * @return array
     */
    public function toArray() {
        $game['id'] = $this->id;
        $game['name'] = $this->name();
        $game['description'] = $this->description();
        $game['numOfPlayers'] = $this->numOfPlayers();
        $game['players'] = $this->players();
        $game['started'] = $this->started();
        return $game;
    }
}
