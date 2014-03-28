<?php

namespace reClick\Controllers;

class BaseController {

    /**
     * @var int
     */
    protected $id;

    /**
     * Model instance
     *
     * @var
     */
    protected $model;

    /**
     * Constructor
     *
     * @param int $id
     */
    public function __construct($id = null) {
        $this->id = isset($id) ? $id : null;
    }

    /**
     * Get's the ID
     *
     * @return int
     */
    public function id() {
        return $this->id;
    }

    /**
     * Generic Getter/Setter
     *
     * @param string $column
     * @param string $val
     * @return int|string
     */
    protected function getSet($column, $val = null) {
        if (isset($val)) {
            return $this->model->setOne($this->id, $column, $val);
        }

        return $this->model->getOne($this->id,$column);
    }
} 