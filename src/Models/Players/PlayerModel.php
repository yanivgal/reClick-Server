<?php

namespace reClick\Models\Players;

use reClick\Models\BaseModel;

class PlayerModel extends BaseModel {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->table = 'players';
    }

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

    public function getIdFromUsername($username) {
        return $this->db->select(
            $this->table,
            ['id'],
            ['username' => $username]
        )->fetchValue();
    }
} 