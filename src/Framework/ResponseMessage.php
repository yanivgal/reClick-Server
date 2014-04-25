<?php

namespace reClick\Framework;

/**
 * Class ResponseMessage
 *
 * This class represents a JSON response message.
 * The structure of the message is implemented per OmniTI Labs describing the
 * JSend specs.
 * Reference: http://labs.omniti.com/labs/jsend
 *
 * @package reClick\Framework
 *
 */
class ResponseMessage {

    const STATUS_INDEX = 'status';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';
    const STATUS_ERROR = 'error';
    const DATA_INDEX = 'data';
    const MESSAGE_INDEX = 'message';

    /**
     * @var array
     */
    private $responseMessage;

    /**
     * @var string
     */
    private $status;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $message;

    /**
     * @param string $status
     *      self::STATUS_SUCCESS|self::STATUS_FAIL|self::STATUS_ERROR
     * @param array $data
     * @param string $message
     */
    public function __construct($status, array $data = null, $message = null) {
        $this->status = $status;
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * @param string|null $status
     * @return ResponseMessage|string
     */
    public function status($status = null) {
        if (isset($status)) {
            $this->status = $status;
            return $this;
        }
        return $status;
    }

    /**
     * @param array|null $data
     * @return ResponseMessage|array|null
     */
    public function data($data = null) {
        if (isset($data)) {
            $this->data = $data;
            return $this;
        }
        return $data;
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

    /**
     * @param string $message
     * @return ResponseMessage|string|null
     */
    public function message($message = null) {
        if (isset($message)) {
            $this->message = $message;
            return $this;
        }
        return $message;
    }

    public function send() {
        $this->responseMessage[self::STATUS_INDEX] = $this->status;
        $this->responseMessage[self::DATA_INDEX] = $this->data;
        $this->responseMessage[self::MESSAGE_INDEX] = $this->message;
        print json_encode($this->responseMessage);
    }

    public function toJson() {
        return json_encode($this->responseMessage);
    }
}