<?php

namespace reClick\Players;

use reClick\Players\Models\PlayerModel;

class Player {

    /**
     * @var int player id
     */
    private $id;

    /**
     * @var Models\PlayerModel
     */
    private $model;

    /**
     * Constructor
     */
    public function __construct() {
        $this->model = new PlayerModel();
    }

    /**
     * @param string $val
     * @return string
     */
    public function username($val = null) {
        return $this->getSet('username', $val);
    }

    private function getSet($column, $val = null) {
        if (is_string($val)) {
            return $this->model->setOne($this->id, $column, $val);
        } else {
            return $this->model->getOne($this->id, $column);
        }
    }

} 