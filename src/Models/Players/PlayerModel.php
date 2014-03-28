<?php

namespace reClick\Models\Players;

use reClick\Models\BaseModel;

class PlayerModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'players';
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $nickname
     * @param string $gcmRegId
     * @return int
     */
    public function create(
        $username,
        $password,
        $nickname,
        $gcmRegId
    ) {
        return $this->db->insert(
            $this->table,
            [
                'username' => $username,
                'password' => $password,
                'nickname' => $nickname,
                'gcm_reg_id' => $gcmRegId
            ]
        );
    }

    /**
     * @param string $username
     * @return string
     */
    public function getIdFromUsername($username) {
        return $this->db->select(
            $this->table,
            ['id'],
            ['username' => $username]
        )->fetchValue();
    }

    /**
     * @param int $id
     * @param string|null $username
     * @return mixed
     */
    public function username($id, $username = null) {
        return $this->getSet($id, 'username', $username);
    }

    /**
     * @param int $id
     * @param string|null $password
     * @return mixed
     */
    public function password($id, $password = null) {
        return $this->getSet($id, 'password', $password);
    }

    /**
     * @param int $id
     * @param string|null $nickname
     * @return mixed
     */
    public function nickname($id, $nickname = null) {
        return $this->getSet($id, 'nickname', $nickname);
    }

    /**
     * @param int $id
     * @param string|null $gcmRegId
     * @return mixed
     */
    public function gcmRegId($id, $gcmRegId = null) {
        return $this->getSet($id, 'gcm_reg_id', $gcmRegId);
    }
} 