<?php

namespace App\Tests\Actions;

use App\Util\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class AgentLogInActionTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_returns_auth_token_when_user_logs_in()
    {
        $this->loadFixtures('user');

        $data = [
            '_username' => 'bog@igra.com',
            '_password' => 'bogigre'
        ];

        $this->client->request('POST', '/api/login_check', $data);

        $this->assertResponse($this->response(), 'auth/log_in_success');
    }

    /**
     * @test
     */
    public function it_returns_not_authorized_response_if_credentials_are_wrong()
    {
        $data = [
            '_username' => 'bog@igra.com',
            '_password' => 'matkobalota'
        ];

        $this->client->request('POST', '/api/login_check', $data);

        $this->assertResponseCode($this->response(), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_returns_bad_request_if_user_is_not_activated()
    {
        $this->loadFixtures('user');

        $data = [
            '_username' => 'elon.musk@tesla.com',
            '_password' => 'theboringpassword'
        ];

        $this->client->request('POST', '/api/login_check', $data);

        $this->assertResponseCode($this->response(), Response::HTTP_BAD_REQUEST);
    }
}
