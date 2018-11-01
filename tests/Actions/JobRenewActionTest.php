<?php

namespace App\Tests\Actions;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Tests\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class JobRenewActionTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_renews_expired_job()
    {
        $this->loadFixtures('jobs');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var JobRepository $job */
        $jobRepository = $this->getEntityManager()->getRepository(Job::class);
        $job = $jobRepository->findOneBy(['status' => Job::STATE_EXPIRED, 'title' => 'I am expired job post']);

        $oldExpirationDate = $job->getExpirationDate();
        $this->assertNotTrue($job->isRenewed());

        $this->client->request('POST', sprintf('/api/job/%s/renew', $job->getId()));
        $this->assertResponseCode($this->response(), Response::HTTP_NO_CONTENT);

        $this->getEntityManager()->refresh($job);
        $this->assertTrue($job->isRenewed());
        $this->assertTrue($job->getExpirationDate() > $oldExpirationDate);
    }

    /**
     * @test
     */
    public function it_returns_an_error_if_job_is_already_renewed()
    {
        $this->loadFixtures('jobs');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var JobRepository $job */
        $jobRepository = $this->getEntityManager()->getRepository(Job::class);
        $job = $jobRepository->findOneBy(['status' => Job::STATE_EXPIRED, 'title' => 'I am expired renewed job post']);

        $this->assertTrue($job->isRenewed());

        $this->client->request('POST', sprintf('/api/job/%s/renew', $job->getId()));
        $this->assertResponseCode($this->response(), Response::HTTP_BAD_REQUEST);

        $this->getEntityManager()->refresh($job);
        $this->assertTrue($job->isRenewed());
    }

    /**
     * @test
     */
    public function it_returns_an_error_if_job_is_not_expired_jet()
    {
        $this->loadFixtures('jobs');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var JobRepository $job */
        $jobRepository = $this->getEntityManager()->getRepository(Job::class);
        $job = $jobRepository->findOneBy(['status' => Job::STATE_ACTIVE]);

        $this->client->request('POST', sprintf('/api/job/%s/renew', $job->getId()));
        $this->assertResponseCode($this->response(), Response::HTTP_BAD_REQUEST);
    }

    public function it_returns_an_error_if_user_is_not_logged_in()
    {
        $this->loadFixtures('jobs');

        /** @var JobRepository $job */
        $jobRepository = $this->getEntityManager()->getRepository(Job::class);
        $job = $jobRepository->findOneBy(['status' => Job::STATE_ACTIVE]);

        $this->client->request('POST', sprintf('/api/job/%s/renew', $job->getId()));
        $this->assertResponseCode($this->response(), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_returns_an_error_if_job_not_found()
    {
        $this->loadFixtures('jobs');
        $this->logUserIn('bog@igra.com', 'bogigre');

        $this->client->request('POST', sprintf('/api/job/%s/renew', 'nope'));
        $this->assertResponseCode($this->response(), Response::HTTP_NOT_FOUND);
    }
}
