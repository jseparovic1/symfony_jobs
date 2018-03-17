<?php

namespace App\Tests\Actions;

use App\Tests\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class AgentShowDetailsTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_shows_added_companies_by_logged_in_user()
    {
        $this->loadFixturesFromFile('user.yml');
        $this->logUserIn('bog@igra.com', 'bogigre');

        $this->client->request('GET', '/api/me/companies');
        $this->assertResponse($this->response(), 'myDetails/show_companies', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_added_jobs_by_logged_in_user()
    {
        $this->loadFixturesFromFile('user.yml');
        $this->logUserIn('bog@igra.com', 'bogigre');

        $this->client->request('GET', '/api/me/jobs');
        $this->assertResponse($this->response(), 'myDetails/show_jobs', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_agents_personal_details()
    {
        $this->loadFixturesFromFile('user.yml');
        $this->logUserIn('bog@igra.com', 'bogigre');

        $this->client->request('GET', '/api/me');
        $this->assertResponse($this->response(), 'myDetails/show_my_details', Response::HTTP_OK);
    }
}
