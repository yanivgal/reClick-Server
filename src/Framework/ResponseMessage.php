<?php

namespace reClick\Framework;

class ResponseMessage {

    private $data;
    const FAILED = 'failed';
    const SUCCESS = 'success';
    const STATUS_INDEX = 'status';
    const EQUALS = 0;

    /**
     * @param array $data
     * @param string $isSuccess ('success' or 'failed')
     */
    public function __construct($isSuccess, array $data = null) {
        $this->data = $data;
        $this->data[self::STATUS_INDEX] =
            strcasecmp($isSuccess, self::SUCCESS) == Self::EQUALS ?
            self::SUCCESS : self::FAILED;
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