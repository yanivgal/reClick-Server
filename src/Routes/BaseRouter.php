<?php

namespace reClick\Routes;

class BaseRouter {

    /**
     * @param array $requestObject
     * @param array $expectedVars
     * @return array
     */
    public function initRequestVars($requestObject, $expectedVars) {
        $initVars = [];

        foreach ($expectedVars as $expectedVar) {
            $initVars[$expectedVar] = isset($requestObject[$expectedVar])
                ? $requestObject[$expectedVar] : null;
        }

        return $initVars;
    }
} 