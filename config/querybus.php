<?php
return [
    /**
     * The Chain of Middleware you wish the query bus to use. Can be left black for simple resolving.
     */
    'query_bus_middleware' => [],

    'query_bus_translator' => App\BundlesContext\Core\Infra\QueryBus\QueryTranslator::class
];
