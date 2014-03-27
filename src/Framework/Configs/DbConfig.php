<?php

namespace reClick\Framework\Configs;

class DbConfig extends BaseConfig {

    /**
     * Returns database driver name
     *
     * @return string
     */
    public function driver() {
        return parent::getValue('driver');
    }

    /**
     * Returns database name
     *
     * @return string
     */
    public function dbName() {
        return parent::getValue('dbname');
    }

    /**
     * Returns database host name
     *
     * @return string
     */
    public function host() {
        return parent::getValue('host');
    }

    /**
     * Returns database username
     *
     * @return string
     */
    public function username() {
        return parent::getValue('username');
    }

    /**
     * Returns database password
     *
     * @return string
     */
    public function password() {
        return parent::getValue('password');
    }
} 