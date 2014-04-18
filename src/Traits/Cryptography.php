<?php

namespace reClick\Traits;

trait Cryptography {

    /**
     * Hash a given password string using MD5 (message-digest) algorithm
     *
     * @param string $password
     * @return string
     */
    public function hashPassword($password) {
        return md5($password);
    }
} 