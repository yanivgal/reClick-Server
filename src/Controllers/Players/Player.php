<?php

namespace reClick\Controllers\Players;

use reClick\Controllers\BaseController;
use reClick\Traits\Cryptography;
use reClick\Models\Players\PlayerModel;

class Player extends BaseController {

    use Cryptography;

    const HASH_PASSWORD = true;
    const RAW_PASSWORD = false;

    /**
     * @param int|string $identifier Player's ID|Username
     */
    public function __construct($identifier) {
        $this->model = new PlayerModel();

        if (is_numeric($identifier) && floor($identifier) == $identifier) {
            parent::__construct($identifier);
        } else {
            parent::__construct($this->model->getIdFromUsername($identifier));
        }
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
} 