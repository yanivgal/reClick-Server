<?php

namespace reClick\GCM;

class Response {

    /**
     * @var \Guzzle\Http\Message\Response $response
     */
    private $guzzleResponse;

    /**
     * @var array
     */
    private $responseArray;

    /**
     * @param \Guzzle\Http\Message\Response $response
     */
    public function __construct(\Guzzle\Http\Message\Response $response) {
        $this->guzzleResponse = $response;
        $this->responseArray = json_decode($response->getBody(), true);
    }

    /**
     * @return int
     */
    public function statusCode() {
        return $this->guzzleResponse->getStatusCode();
    }

    /**
     * @return string
     */
    public function body() {
        return $this->guzzleResponse->getBody();
    }

    /**
     * @return string
     */
    public function multicastId() {
        return number_format($this->responseArray['multicast_id'], 0, '.', '');
    }

    /**
     * @return int
     */
    public function successes() {
        return $this->responseArray['success'];
    }

    /**
     * @return int
     */
    public function failures() {
        return $this->responseArray['failure'];
    }

    /**
     * @return int
     */
    public function totalMessages() {
        return $this->responseArray['success'] + $this->responseArray['failure'];
    }

    /**
     * @return int
     */
    public function canonicalIds() {
        return $this->responseArray['canonical_ids'];
    }

    /**
     * @return array
     */
    public function results() {
        return $this->responseArray['results'];
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->guzzleResponse->getMessage();
    }
}
