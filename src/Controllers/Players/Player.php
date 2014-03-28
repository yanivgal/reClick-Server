<?php

namespace reClick\Controllers\Players;

use reClick\Controllers\BaseController;
use reClick\Models\Players\PlayerModel;

class Player extends BaseController {

    /**
     * Constructor
     *
     * @param int $id Player's ID
     */
    public function __construct($id = null) {
        parent::__construct($id);
        $this->model = new PlayerModel();
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

    /**
     * Gets Sets player's nickname
     *
     * @param string $nickname
     * @return int|string
     */
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
     * Hash given password string using MD5 (message-digest) algorithm
     *
     * @param string $password
     * @return string
     */
    private function hashPassword($password) {
        return md5($password);
    }

} 