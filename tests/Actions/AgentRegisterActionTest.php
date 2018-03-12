<?php

namespace App\Tests\Actions;

use App\Util\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class AgentRegisterActionTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_registers_user()
    {
        $data = [
            'name' => 'Mark Zukemberg',
            'email' => 'marck.zuckemberg@facebook.com',
            'password' => 'markisa',
            'passwordConfirm' => 'markisa'
        ];

        $this->client->request('POST', '/api/register', $data);

        $this->assertResponseCode($this->response(), Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_validates_password_length_and_unique_email()
    {
        $this->loadFixtures('user');

        $data = [
            'name' => 'Mark Zukemberg',
            'email' => 'bog@igra.com',
            'password' => 'mar',
            'passwordConfirm' => 'mar'
        ];

        $this->client->request('POST', '/api/register', $data);

        $this->assertResponse($this->response(), 'auth/registration_validation', Response::HTTP_BAD_REQUEST);
    }
}
