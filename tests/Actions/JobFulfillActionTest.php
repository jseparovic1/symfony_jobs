<?php

namespace App\Tests\Actions;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Tests\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class JobFulfillActionTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_can_fulfill_active_job()
    {
        $this->loadFixtures('jobs');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var JobRepository $job */
        $jobRepository = $this->getEntityManager()->getRepository(Job::class);
        $job = $jobRepository->findOneBy(['status' => Job::STATE_ACTIVE]);

        $this->client->request('POST', sprintf('/api/job/%s/fulfill', $job->getId()));
        $this->assertResponseCode($this->response(), Response::HTTP_NO_CONTENT);
    }

    /**
     * @test
     */
    public function it_can_fulfill_expired_job()
    {
        $this->loadFixtures('jobs');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var JobRepository $job */
        $jobRepository = $this->getEntityManager()->getRepository(Job::class);
        $job = $jobRepository->findOneBy(['status' => Job::STATE_EXPIRED]);

        $this->client->request('POST', sprintf('/api/job/%s/fulfill', $job->getId()));
        $this->assertResponseCode($this->response(), Response::HTTP_NO_CONTENT);
    }

    /**
     * @test
     */
    public function it_returns_an_error_if_user_is_not_logged_in()
    {
        $this->loadFixtures('jobs');

        /** @var JobRepository $job */
        $jobRepository = $this->getEntityManager()->getRepository(Job::class);
        $job = $jobRepository->findOneBy(['status' => Job::STATE_EXPIRED]);

        $this->client->request('POST', sprintf('/api/job/%s/fulfill', $job->getId()));
        $this->assertResponseCode($this->response(), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_returns_an_error_if_job_not_found()
    {
        $this->loadFixtures('jobs');
        $this->logUserIn('bog@igra.com', 'bogigre');

        $this->client->request('POST', sprintf('/api/job/%s/fulfill', 'nope'));
        $this->assertResponseCode($this->response(), Response::HTTP_NOT_FOUND);
    }
}
