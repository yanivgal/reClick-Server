<?php

namespace reClick\Framework\Configs;

class GcmConfig extends BaseConfig {

    /**
     * Returns GCM API Key
     *
     * @return string
     */
    public function apiKey() {
        return parent::getValue('apikey');
    }
} 