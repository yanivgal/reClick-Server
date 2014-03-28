<?php

namespace reClick\Framework\Configs;

class DbConfig extends BaseConfig {

    /**
     * @return string
     */
    public function driver() {
        return $this->getValue('driver');
    }

    /**
     * @return string
     */
    public function dbName() {
        return $this->getValue('dbname');
    }

    /**
     * @return string
     */
    public function host() {
        return $this->getValue('host');
    }

    /**
     * @return string
     */
    public function username() {
        return $this->getValue('username');
    }

    /**
     * @return string
     */
    public function password() {
        return $this->getValue('password');
    }
} 