<?php

namespace Tests\Unit\BoundedContext\Backoffice\Auth\Application\Service;

use App\BoundedContext\Backoffice\Auth\Application\Request\AuthTokenCheckerRequest;
use App\BoundedContext\Backoffice\Auth\Application\Service\AuthTokenCheckerService;
use Tests\TestCase;

class AuthTokenCheckerServiceTest extends TestCase
{

    public function checkProvider() {

        return [
            [ "" , false],
            [ "{}" , true],
            [ "{}[]()" , true],
            [ "{)" , false],
            [ "[{]}" , false],
            [ "{([])}" , true],
            [ "(((((((()" , false],
            ["{(", false]
        ];
    }

    /**
     * @param $token
     * @dataProvider checkProvider
     * @return void
     */
    public function testCheck($token, $expected) {
        $request = new AuthTokenCheckerRequest($token);
        $checkerService = new AuthTokenCheckerService();
        $response = $checkerService->check($request);

        $this->assertEquals($expected, $response->isValid());

    }

}
