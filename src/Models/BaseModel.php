<?php

namespace reClick\Models;

use reClick\Framework\Db;

class BaseModel {

    /**
     * @var \reClick\Framework\Db
     */
    protected $db;

    /**
     * @var string table name
     */
    protected $table;

    /**
     * Constructor
     */
    public function __construct() {
        $this->db = new Db();
    }

    /**
     * Gets one column where id = $id
     *
     * @param int $id
     * @param string $column
     * @return string
     */
    public function getOne($id, $column) {
        return $this->db->select(
            $this->table,
            [$column],
            ['id' => $id]
        )->fetchValue();
    }

    /**
     * Sets one column where id = $id
     *
     * @param int $id
     * @param string $column
     * @param string $value
     * @return int number of effected rows
     */
    public function setOne($id, $column, $value) {
        return $this->db->update(
            $this->table,
            [$column => $value],
            ['id' => $id]
        );
    }

} 