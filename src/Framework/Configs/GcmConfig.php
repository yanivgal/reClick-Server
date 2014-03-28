<?php

namespace reClick\Framework\Configs;

class GcmConfig extends BaseConfig {

    /**
     * @return string
     */
    public function apiKey() {
        return $this->getValue('apikey');
    }
} 