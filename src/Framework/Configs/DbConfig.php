<?php

namespace reClick\Framework\Configs;

class DbConfig extends BaseConfig {

    /**
     * Returns database driver name
     *
     * @return string
     */
    public function driver() {
        return $this->getValue('driver');
    }

    /**
     * Returns database name
     *
     * @return string
     */
    public function dbName() {
        return $this->getValue('dbname');
    }

    /**
     * Returns database host name
     *
     * @return string
     */
    public function host() {
        return $this->getValue('host');
    }

    /**
     * Returns database username
     *
     * @return string
     */
    public function username() {
        return $this->getValue('username');
    }

    /**
     * Returns database password
     *
     * @return string
     */
    public function password() {
        return $this->getValue('password');
    }
} 