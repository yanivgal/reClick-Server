<?php

namespace reClick\Framework\Configs;

abstract class ConfigBase {

    /**
     * @var array $iniArr parsed ini file as array
     */
    private $iniArr;

    /**
     * Constructor
     *
     * @param array $iniArr parsed ini file as array
     */
    public function __construct(array $iniArr) {
        $this->iniArr = $iniArr;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getValue($name) {
        return $this->iniArr[$name];
    }
} 