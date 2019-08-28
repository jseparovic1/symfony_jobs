<?php

namespace App\Tests\Actions;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class AgentActivateActionTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_validates_user_account()
    {
        $this->loadFixtures('user');

        /** @var UserRepository $userRepository */
        $userRepository = $this->getEntityManager()->getRepository(User::class);
        $user = $userRepository->findOneByEmail('elon.musk@tesla.com');

        $data = [
            'userId' => $user->getId(),
            'confirmationToken' => $user->getConfirmationToken()
        ];

        $this->client->request('POST', '/api/activate', $data);

        $this->assertResponseCode($this->response(), Response::HTTP_NO_CONTENT);
    }

    /**
     * @test
     */
    public function it_validates_activation_data()
    {
        $this->loadFixtures('user');

        $data = [
            'userId' => "fucking",
            'confirmationToken' => ""
        ];

        $this->client->request('POST', '/api/activate', $data);

        $this->assertResponse($this->response(), 'auth/activation_data_validation', Response::HTTP_BAD_REQUEST);
    }
}
