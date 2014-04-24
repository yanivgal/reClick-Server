<?php

namespace reClick\Models\Games;

use reClick\Models\BaseModel;

class GamesModel extends BaseModel {

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
     * @return array
     */
    public function getOpenGames() {
        return $this->db->select(
            $this->table,
            ['id', 'num_of_players'],
            ['started' => 0]
        )->fetchAll();
    }
} 