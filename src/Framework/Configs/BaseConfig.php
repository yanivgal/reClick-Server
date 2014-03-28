<?php

namespace reClick\Framework\Configs;

abstract class BaseConfig {

    /**
     * @var array $iniArr parsed ini file as array
     */
    private $iniArr;

    /**
     * @param array $iniArr parsed ini file as array
     */
    public function __construct(array $iniArr) {
        $this->iniArr = $iniArr;
    }

    /**
     * Gets value from ini file
     *
     * @param string $name
     * @return string
     */
    protected function getValue($name) {
        return $this->iniArr[$name];
    }
} 