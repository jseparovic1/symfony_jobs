<?php

namespace App\Tests\Actions;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Util\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class JobEditActionTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_edits_job_details()
    {
        $this->loadFixtures('user');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var JobRepository $jobRepository */
        $jobRepository =$this->getEntityManager()->getRepository(Job::class);
        /** @var Job $job */
        $job = $jobRepository->findByUserEmail('bog@igra.com')[0];

        $data = [
            'description' => "Description",
            'website' => "Website",
            'location' => 'location',
            'title' => 'title',
            'remote' => false
        ];

        $this->client->request('PUT', sprintf('/api/job/%s', $job->getId()), $data);
        $this->assertResponse($this->response(), 'jobs/edit_job_success', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_validates_that_required_fields_are_not_empty()
    {
        $this->loadFixtures('user');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var JobRepository $jobRepository */
        $jobRepository =$this->getEntityManager()->getRepository(Job::class);
        /** @var Job $job */
        $job = $jobRepository->findByUserEmail('bog@igra.com')[0];

        $data = [
            'description' => '',
            'website' => '',
            'location' => '',
            'title' => ''
        ];

        $this->client->request('PUT', sprintf('/api/job/%s', $job->getId()), $data);
        $this->assertResponse($this->response(), 'jobs/edit_job_validation', Response::HTTP_BAD_REQUEST);
    }
}
