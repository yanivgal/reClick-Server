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
    protected  function getOne($id, $column) {
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
    protected  function setOne($id, $column, $value) {
        return $this->db->update(
            $this->table,
            [$column => $value],
            ['id' => $id]
        );
    }

    /**
     * Generic Getter/Setter
     *
     * @param int $id
     * @param string $column
     * @param string|null $val
     * @return mixed
     */
    protected function getSet($id, $column, $val = null) {
        if (isset($val)) {
            return $this->model->setOne($id, $column, $val);
        }

        return $this->model->getOne($id,$column);
    }

} 