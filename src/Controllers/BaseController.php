<?php

namespace reClick\Controllers;

class BaseController {

    /**
     * @var int $id
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
    public function __construct($id) {
        $this->id = filter_var($id, FILTER_VALIDATE_INT) && (int) $id >= 0
            ? $id : null;
    }

    /**
     * Get's the ID
     *
     * @return int
     */
    public function id() {
        return $this->id;
    }
} 