<?php

namespace reClick\Controllers\Players;

use reClick\Controllers\BaseController;
use reClick\Models\Players\PlayerModel;

class Player extends BaseController {

    const HASH_PASSWORD = true;
    const RAW_PASSWORD = false;

    /**
     * @param int $id Player ID
     */
    public function __construct($id = null) {
        parent::__construct($id);
        $this->model = new PlayerModel();
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

        $this->id = $this->model->create(
            $username,
            $password,
            $nickname,
            $gcmRegId
        );

        return $this;
    }

    /**
     * @param $username
     * @return Player
     */
    public function fromUsername($username) {
        $this->id = $this->model->getIdFromUsername($username);

        return $this;
    }

    /**
     * @param string $username
     * @return int|string
     */
    public function username($username = null) {
        return $this->model->username($this->id, $username);
    }

    /**
     * @param string $password
     * @param bool $hashPassword HASH_PASSWORD | RAW_PASSWORD
     * @return int|string
     */
    public function password($password = null, $hashPassword = self::RAW_PASSWORD) {
        if (isset($password) && $hashPassword) {
            $password = $this->hashPassword($password);
        }

        return $this->model->password($this->id, $password);
    }

    /**
     * @param string $nickname
     * @return int|string
     */
    public function nickname($nickname = null) {
        return $this->model->nickname($this->id, $nickname);
    }

    /**
     * @param string $gcmRegId
     * @return int|string
     */
    public function gcmRegId($gcmRegId = null) {
        return $this->model->gcmRegId($this->id, $gcmRegId);
    }

    /**
     * Hash a given password string using MD5 (message-digest) algorithm
     *
     * @param string $password
     * @return string
     */
    private function hashPassword($password) {
        return md5($password);
    }

} 