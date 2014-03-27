<?php

namespace reClick\Players;

use reClick\Models\PlayerModel;

class Player {

    /**
     * @var int player id
     */
    private $id;

    /**
     * @var \reClick\Models\PlayerModel
     */
    private $model;

    /**
     * Constructor
     *
     * @param int $id
     */
    public function __construct($id = null) {
        $this->model = new PlayerModel();
        $this->id = isset($id) ? $id : null;
    }

    /**
     * Creates a new player
     *
     * @param string $username
     * @param string $password
     * @param string $nickname
     * @param string $gcmRegId
     * @return Player
     */
    public function create(
        $username,
        $password,
        $nickname,
        $gcmRegId
    ) {
        $this->id = $this->model->create(
            $username,
            $this->hashPassword($password),
            $nickname,
            $gcmRegId
        );

        return $this;
    }

    /**
     * Gets player's ID
     *
     * @return int
     */
    public function id() {
        return $this->id;
    }

    /**
     * Gets a player from his username
     *
     * @param $username
     * @return Player
     */
    public function fromUsername($username) {
        $this->id = $this->model->getIdFromUsername($username);

        return $this;
    }

    /**
     * Gets Sets player's username
     *
     * @param string $username
     * @return int|string
     */
    public function username($username = null) {
        return $this->getSet('username', $username);
    }

    /**
     * Gets Sets player's password
     *
     * @param string $password
     * @return int|string
     */
    public function password($password = null) {
        if (isset($password)) {
            $password = $this->hashPassword($password);
        }

        return $this->getSet('password', $password);
    }

    public function nickname($nickname = null) {
        return $this->getSet('nickname', $nickname);
    }

    /**
     * Gets Sets player's GCM registration ID
     *
     * @param string $gcmRegId
     * @return int|string
     */
    public function gcmRegId($gcmRegId = null) {
        return $this->getSet('gcm_reg_id', $gcmRegId);
    }

    /**
     * Generic Getter/Setter
     *
     * @param string $column
     * @param string $val
     * @return int|string
     */
    private function getSet($column, $val = null) {
        if (isset($val)) {
            return $this->model->setOne($this->id, $column, $val);
        }

        return $this->model->getOne($this->id,$column);
    }

    private function hashPassword($password) {
        return md5($password);
    }

} 