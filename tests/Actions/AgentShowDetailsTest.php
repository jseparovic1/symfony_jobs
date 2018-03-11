<?php

namespace App\Tests\Actions;

use App\Util\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class AgentShowDetailsTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_validates_user_account()
    {
        $this->loadFixturesFromFile('user.yml');
        $this->logUserIn('bog@igra.com', 'bogigre');

        $this->client->request('GET', '/api/me/companies');
        $this->assertResponse($this->response(), 'empty', Response::HTTP_OK);
    }
}
