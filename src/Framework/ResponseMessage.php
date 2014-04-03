<?php

namespace reClick\Framework;

class ResponseMessage {

    const FAILED = 'failed';
    const SUCCESS = 'success';
    const STATUS_INDEX = 'status';

    /**
     * @var array|null $data
     */
    private $data;

    /**
     * @param string $isSuccess self::SUCCESS|self::FAILED
     * @param array|null $data
     */
    public function __construct($isSuccess, array $data = null) {
        $this->data = $data;
        $this->data[self::STATUS_INDEX] = $isSuccess;
    }

    /**
     * @param string $key
     * @param string $value
     * @return ResponseMessage
     */
    public function addData($key, $value) {
        $this->data[$key] = $value;

        return $this;
    }

    public function send() {
        print json_encode($this->data);
    }
}