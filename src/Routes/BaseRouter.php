<?php

namespace reClick\Routes;

use reClick\Framework\ResponseMessage;
use Slim\Slim;

abstract class BaseRouter {

    /**
     * @var null|\Slim\Slim
     */
//    protected $app;

    protected function __construct()
    {
//        $this->app = Slim::getInstance();
        $this->initializeRoutes();
    }

    /**
     * Implement all relevant routes here
     */
    protected abstract function initializeRoutes();

    /**
     * @param array $requestObject
     * @param array $expectedVars
     * @return array
     */
    public function initRequestVars($requestObject, $expectedVars) {
        $initVars = [];

        foreach ($expectedVars as $expectedVar) {
            if (!isset($requestObject[$expectedVar])) {
                (new ResponseMessage(ResponseMessage::FAILED))
                    ->addData('message', $expectedVar . ' is required')
                    ->send();
                exit;
            }

            $initVars[$expectedVar] = isset($requestObject[$expectedVar])
                ? $requestObject[$expectedVar] : null;
        }

        return $initVars;
    }
} 