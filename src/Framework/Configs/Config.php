<?php

namespace reClick\Framework\Configs;

class Config {

    /**
     * @return DbConfig
     */
    public function db() {
        return new DbConfig(
            $this->parseFile($this->getIniFile('database'))
        );
    }

    /**
     * @return GcmConfig
     */
    public function gcm() {
        return new GcmConfig(
            $this->parseFile($this->getIniFile('gcm'))
        );
    }

    /**
     * @param string $filename
     * @return string ini file's filename
     */
    private function getIniFile($filename) {
        return $this->getAllIniFiles()[$filename];
    }

    /**
     * @return array All ini file names as array
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
     * @param string $fileName
     * @return array parsed ini file as array
     */
    private function parseFile($fileName) {
        return parse_ini_file($fileName);
    }
} 