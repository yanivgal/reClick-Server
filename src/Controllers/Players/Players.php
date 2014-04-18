<?php

namespace reClick\Controllers\Players;

use \reClick\Traits\Cryptography;
use reClick\Models\Players\PlayersModel;

class Players {

    use Cryptography;

    /**
     * @var PlayersModel
     */
    private $model;

    public function __construct() {
        $this->model = new PlayersModel();
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $nickname
     * @param string $gcmRegId
     * @param bool $hashPassword
     * @return Player
     */
    public function create(
        $username,
        $password,
        $nickname,
        $gcmRegId,
        $hashPassword = false
    ) {
        if ($hashPassword) {
            $password = $this->hashPassword($password);
        }

        $id = $this->model->create(
            $username,
            $password,
            $nickname,
            $gcmRegId
        );

        return new Player($id);
    }
} 