<?php

namespace reClick\Models\Players;

use reClick\Models\BaseModel;

class PlayersModel extends BaseModel {

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

} 