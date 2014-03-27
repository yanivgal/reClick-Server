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

    /**
     * Returns ini file's filename
     *
     * @param string $filename
     * @return string
     */
    private function getIniFile($filename) {
        return $this->getAllIniFiles()[$filename];
    }

    /**
     * Returns all ini files as array
     *
     * @return array
     */
    private function getAllIniFiles() {
        $iniFiles = glob('*.ini');

        foreach ($iniFiles as $key => $path) {
            $iniFiles[pathinfo($path, PATHINFO_FILENAME)] = $path;
            unset($iniFiles[$key]);
        }

        return $iniFiles;
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