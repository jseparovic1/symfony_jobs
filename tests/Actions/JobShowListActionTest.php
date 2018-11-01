<?php

namespace App\Tests\Actions;

use App\Tests\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class JobShowListActionTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_shows_active_jobs_list()
    {
        $this->loadFixtures('user');
        $this->client->request('GET', '/api/jobs');
        $this->assertResponse($this->response(), 'jobs/show_list', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_can_search_only_remote_jobs()
    {
        $this->loadFixtures('user');
        $this->client->request('GET', '/api/jobs?remote=true');
        $this->assertResponse($this->response(), 'jobs/show_remote_list', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_can_search_job_by_title()
    {
        $this->loadFixtures('user');
        $this->client->request('GET', '/api/jobs?search=symfony');
        $this->assertResponse($this->response(), 'jobs/show_search_result', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_can_search_job_by_title_and_remote()
    {
        $this->loadFixtures('user');
        $this->client->request('GET', '/api/jobs?search=symfony&remote=true');
        $this->assertResponse($this->response(), 'jobs/show_search_remote_and_title', Response::HTTP_OK);
    }
}
