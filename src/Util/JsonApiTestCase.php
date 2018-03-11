<?php

namespace App\Util;

use Lakion\ApiTestCase\JsonApiTestCase as BaseJsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonApiTestCase
 */
class JsonApiTestCase extends BaseJsonApiTestCase
{
    /**
     * @param $username
     * @param null $password
     */
    public function logUserIn($username, $password)
    {
        $data = [
            '_username' => $username,
            '_password' => $password
        ];

        $this->sendJsonRequest('POST', '/api/login', json_encode($data));
        $this->assertResponseCode($this->client->getResponse(), Response::HTTP_OK);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $response['token']));
    }

    /**
     * @param string $method
     * @param string $uri
     * @param null $data
     */
    protected function sendJsonRequest(string $method, string $uri, $data = null)
    {
        $this->client->request(
            $method,
            $uri,
            [],
            [],
            ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $data
        );
    }

    /**
     * @return Response
     */
    protected function response()
    {
        return $this->client->getResponse();
    }

    /**
     * @param array $fixtures
     */
    public function loadFixtures(...$fixtures)
    {
        foreach ($fixtures as $fixture) {
            $this->loadFixturesFromFile($fixture . '.yml');
        }
    }
}
