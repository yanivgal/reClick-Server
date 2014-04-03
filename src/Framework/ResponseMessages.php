<?php

namespace reClick\Framework;

use reClick\Framework\Configs\Config;

class ResponseMessages {

    private $data;
    const FAILED = 'failed';
    const SUCCESS = 'success';
    const STATUS_INDEX = 'status';
    const EQUALS = 0;

    /**
     * @param array $data
     * @param string $isSuccess ('success' or 'failed')
     */
    public function __construct(array $data = null, $isSuccess = FAILED) {
        $this->data = $data;
        $this->data[STATUS_INDEX] = strcasecmp($isSuccess, SUCCESS) == EQUALS ?
            SUCCESS : FAILED;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addData($key, $value) {
        $this->data[$key] = $value;

        return $this;
    }

    public function sendDataInJasonFormat() {
        print getDataInJasonFormat();
    }

    /**
     * @return string
     */
    private function getDataInJasonFormat() {
        return json_encode($this->data);
    }
}