<?php

namespace App\Tests\Actions;

use App\Util\JsonApiTestCase;

class LogInTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_returns_token_when_user_logs_in()
    {
        $this->loadFixtures('user', 'company');

        $this->client->request('GET', '/api/jobs');

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'hi');
    }
}
