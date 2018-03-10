<?php

namespace App\Tests\Actions;

use App\Util\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class LogInTest extends JsonApiTestCase
{
//    public static function createKernel(array $options = [])
//    {
//        return new Kernel('test', true);
//    }

    /**
     * @test
     */
    public function it_returns_token_when_user_logs_in()
    {
        $this->loadFixturesFromFile('user.yml');

        $response = $this->sendJsonRequest('GET', '/api/login_check', ['_username' => 'matko' , '_password' => 'pero']);

        $this->assertResponseCode($response, Response::HTTP_BAD_REQUEST);
    }
}
