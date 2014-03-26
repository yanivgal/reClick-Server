<?php

namespace reClick\Framework\Configs;

class DbConfig extends ConfigBase{

    /**
     * Constructor
     *
     * @param array $iniArr parsed ini file as array
     */
    public function __construct(array $iniArr) {
        parent::__construct($iniArr);
    }

    /**
     * @return string
     */
    public function driver() {
        return $this->getValueFromParent('driver');
    }

    /**
     * @return string
     */
    public function dbName() {
        return $this->getValueFromParent('dbname');
    }

    /**
     * @return string
     */
    public function host() {
        return $this->getValueFromParent('host');
    }

    /**
     * @return string
     */
    public function username() {
        return $this->getValueFromParent('username');
    }

    /**
     * @return string
     */
    public function password() {
        return $this->getValueFromParent('password');
    }

    /**
     * @param string $name
     * @return string
     */
    private function getValueFromParent($name) {
        return parent::getValue($name);
    }
} 