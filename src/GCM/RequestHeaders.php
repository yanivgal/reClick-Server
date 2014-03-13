<?php

namespace reClick\GCM;

class RequestHeaders {

    private $authorization;
    private $contentType;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $contentType
     */
    public function __construct(
        $apiKey = null,
        $contentType = 'application/json'
    ) {
        $this->authorization = 'key=' . $apiKey;
        $this->contentType = $contentType;
    }

    /**
     * Gets\Sets content-type request header
     *
     * @param string $contentType
     * @return RequestHeaders|string
     */
    public function contentType($contentType = null) {
        if (!isset($contentType)) {
            return $this->contentType;
        }

        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Gets\Sets authorization request header
     *
     * @param string $apiKey
     * @return RequestHeaders|string
     */
    public function authorization($apiKey = null) {
        if (!isset($apiKey)) {
            return $this->authorization;
        }

        $this->authorization = 'key=' . $apiKey;

        return $this;
    }
}
