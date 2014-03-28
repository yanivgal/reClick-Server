<?php

namespace reClick\GCM;

use Guzzle\Http\Client;
use reClick\Framework\Configs\Config;
use reClick\Framework\Configs\GcmConfig;

class GCM {

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var Message $message
     */
    private $message;

    /**
     * @var RequestHeaders $requestHeaders
     */
    private $requestHeaders;

    /**
     * @var \Guzzle\Http\Client $client
     */
    private $client;

    /**
     * @var \Guzzle\Http\Message\Response $response
     */
    private $guzzleResponse;

    /**
     * @var Response $response
     */
    private $response;

    public function __construct() {
        $gcmConfig = (new Config())->gcm();
        $apiKey = $gcmConfig->apiKey();
        $this->apiKey = $apiKey;
        $this->requestHeaders = new RequestHeaders($apiKey);
        $this->message = new Message();
        $this->client = new Client();
    }

    /**
     * @param RequestHeaders $requestHeaders
     * @return RequestHeaders|GCM
     */
    public function requestHeaders(RequestHeaders $requestHeaders = null) {
        return $this->getterSetter('requestHeaders', $requestHeaders);
    }

    /**
     * @param Message|null $message
     * @return GCM|Message
     */
    public function message(Message $message = null) {
        return $this->getterSetter('message', $message);
    }

    /**
     * @return Response
     */
    public function sendMessage() {
        $this->guzzleResponse = $this->client
            ->post('https://android.googleapis.com/gcm/send')
            ->setHeader('Content-Type', $this->requestHeaders()->contentType())
            ->setHeader('Authorization', $this->requestHeaders()->authorization())
            ->setBody($this->message)
            ->send();

        $this->response = new Response($this->guzzleResponse);

        return $this->response;
    }

    /**
     * @return \Guzzle\Http\Message\Response
     */
    public function guzzleResponse() {
        return $this->guzzleResponse;
    }

    public function apiKey($apiKey = null) {
        if (!isset($apiKey)) {
            return $this->apiKey;
        }

        $this->apiKey = $apiKey;
        $this->requestHeaders()->authorization($apiKey);

        return $this;
    }

    /**
     * Generic simple getter/setter
     *
     * @param string $property
     * @param string|null $value
     * @return Message|mixed
     */
    private function getterSetter($property, $value = null) {
        if (property_exists($this, $property)) {
            if (!isset($value)) {
                return $this->$property;
            }

            $this->$property = $value;
        }

        return $this;
    }
}
