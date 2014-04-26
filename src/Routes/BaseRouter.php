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
     * @param array $expectedVars
     * @return array
     */
    public function initJsonVars($requestBody, $expectedVars) {
        return self::initVars($requestBody, $expectedVars, 'json');
    }

    /**
     * @param array $getObject
     * @param array $expectedVars
     * @return array
     */
    public function initGetVars($getObject, $expectedVars) {
        return self::initVars($getObject, $expectedVars, 'get');
    }

    /**
     * @param string|array $request
     * @param array $expectedVars
     * @param string $method
     * @return array
     */
    private function initVars($request, $expectedVars, $method) {
        if ($method != 'get') {
            $requestVars = json_decode($request, true);
            if (json_last_error() != JSON_ERROR_NONE) {
                (new ResponseMessage(ResponseMessage::STATUS_ERROR))
                    ->message(json_last_error_msg())
                    ->send();
                exit;
            }
        }

        $initVars = [];
        foreach ($expectedVars as $expectedVar) {
            if (!isset($requestVars[$expectedVar])) {
                (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                    ->message($expectedVar . ' is required as ' . $method
                        . ' parameter')
                    ->send();
                exit;
            }
            $initVars[$expectedVar] = $requestVars[$expectedVar];
        }
        return $initVars;
    }
} 