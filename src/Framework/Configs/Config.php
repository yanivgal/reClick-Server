<?php

namespace reClick\Framework\Configs;

class Config {

    /**
     * Returns instantiated DbConfig object
     *
     * @return DbConfig
     */
    public function db() {
        return new DbConfig(
            $this->parseFile($this->getIniFile('database'))
        );
    }

    /**
     * Returns instantiated GcmConfig object
     *
     * @return GcmConfig
     */
    public function gcm() {
        return new GcmConfig(
            $this->parseFile($this->getIniFile('gcm'))
        );
    }

    private function getIniFile($filename) {
        $iniArr = glob('*.ini');

        foreach ($iniArr as $key => $path) {
            $info = pathinfo($path);
            $iniArr[$info['filename']] = $path;
            unset($iniArr[$key]);
        }

        return $iniArr[$filename];
    }

    /**
     * Parses ini file and returns it as array
     *
     * @param string $fileName
     * @return array parsed ini file as array
     */
    private function parseFile($fileName) {
        return parse_ini_file($fileName);
    }
} 