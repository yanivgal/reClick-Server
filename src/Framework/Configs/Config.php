<?php

namespace reClick\Framework\Configs;

class Config {

    /**
     * @var array all ini files
     */
    private $iniFiles = [
        'db' => 'database.ini'
    ];

    /**
     * Constructor
     */
    public function __construct() {}

    /**
     * @return DbConfig
     */
    public function db() {
        return new DbConfig(
            $this->parseFile($this->iniFiles['db'])
        );
    }

    /**
     * @param string $fileName
     * @return array parsed ini file as array
     */
    private function parseFile($fileName) {
        return parse_ini_file($fileName);
    }
} 