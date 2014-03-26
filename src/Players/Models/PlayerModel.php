<?php

namespace reClick\Players\Models;

use reClick\Framework\Db;

class PlayerModel {

    /**
     * @var \reClick\Framework\Db
     */
    private $db;

    /**
     * @var string table name
     */
    private $table;

    /**
     * Constructor
     */
    public function __construct() {
        $this->db = new Db();
        $this->table = 'players';
    }

    /**
     * @param int $id
     * @param string $column
     * @return string
     */
    public function getOne($id, $column) {
        return '';
    }

    /**
     * @param int $id
     * @param string $column
     * @param string $value
     * @return string
     */
    public function setOne($id, $column, $value) {
        return '';
    }
} 