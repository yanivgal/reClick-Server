<?php

namespace reClick\Routes;

use Slim\Slim;
use reClick\Framework\ResponseMessage;

abstract class BaseRouter {

    /**
     * @var \Slim\Slim
     */
    protected $app;

    protected function __construct() {
        $this->app = Slim::getInstance();
        $this->initializeRoutes();
    }

    /**
     * Implement all relevant routes here
     */
    abstract protected function initializeRoutes();

    /**
     * @param string $requestBody
     * @param array $requiredVars
     * @param array $optionalVars
     * @return array
     */
    public function initJsonVars(
        $requestBody,
        $requiredVars,
        $optionalVars = []
    ) {
        return self::initVars(
            $requestBody,
            'json',
            $requiredVars,
            $optionalVars
        );
    }

    /**
     * @param array $getObject
     * @param array $requiredVars
     * @param array $optionalVars
     * @return array
     */
    public function initGetVars(
        $getObject,
        $requiredVars,
        $optionalVars = []
    ) {
        return self::initVars(
            $getObject,
            'get',
            $requiredVars,
            $optionalVars
        );
    }

    /**
     * @param string|array $request
     * @param array $requiredVars
     * @param array $optionalVars
     * @param string $method
     * @return array
     */
    private function initVars(
        $request,
        $method,
        $requiredVars,
        $optionalVars = []
    ) {
        $requiredVars = isset($requiredVars) ? $requiredVars : [];
        $optionalVars = isset($optionalVars) ? $optionalVars : [];


        if ($method != 'get') {
            $requestVars = json_decode($request, true);
            if (json_last_error() != JSON_ERROR_NONE) {
                (new ResponseMessage(ResponseMessage::STATUS_ERROR))
                    ->message(json_last_error_msg())
                    ->send();
                exit;
            }
        } else {
            $requestVars = $request;
        }

        $initVars = [];

        foreach ($requiredVars as $requiredVar) {
            if (!isset($requestVars[$requiredVar])) {
                (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                    ->message($requiredVar . ' is required as ' . $method
                        . ' parameter')
                    ->send();
                exit;
            }
            $initVars[$requiredVar] = $requestVars[$requiredVar];
        }

        foreach ($optionalVars as $optionalVar) {
            $initVars[$optionalVar] = isset($requestVars[$optionalVar])
                ? $requestVars[$optionalVar] : null;
        }

        return $initVars;
    }
}