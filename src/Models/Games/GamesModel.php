<?php

namespace reClick\Models\Games;

use reClick\Models\BaseModel;

class GamesModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'games';
    }

    /**
     * @param string $name
     * @param string $description
     * @return int
     */
    public function create($name, $description) {
        return $this->db->insert(
            $this->table,
            ['name' => $name, 'description' => $description]
        );
    }

    /**
     * @return array
     */
    public function getOpenGames() {
        return $this->db->select(
            $this->table,
            ['id', 'name', 'description', 'num_of_players as numOfPlayers'],
            ['started' => 0]
        )->fetchAll();
    }
} 