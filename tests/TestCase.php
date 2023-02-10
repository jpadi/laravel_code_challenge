<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\Constraint\Callback;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param $arg
     * @return Callback
     */
    protected function captureArg(&$arg): Callback
    {
        return $this->callback(function ($argToMock) use (&$arg) {
            $arg = $argToMock;
            return true;
        });
    }

}
