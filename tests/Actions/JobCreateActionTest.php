<?php

namespace App\Tests\Actions;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Util\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class JobCreateActionTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_creates_job_with_existing_company()
    {
        $this->loadFixtures('user');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var CompanyRepository $companyRepository */
        $companyRepository =$this->getEntityManager()->getRepository(Company::class);
        $company = $companyRepository->findOneBy(['name' => 'Facebook']);

        $data = [
            'description' => "Description",
            'website' => "Website",
            'location' => 'location',
            'title' => 'title',
            'company' => [
                'id' => $company->getId()
            ]
        ];

        $this->client->request('POST', '/api/jobs', $data);
        $this->assertResponseCode($this->response(), Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function id_does_not_create_job_if_company_does_not_exitsts()
    {
        $this->loadFixtures('user');
        $this->logUserIn('bog@igra.com', 'bogigre');

        $data = [
            'description' => "Description",
            'website' => "Website",
            'location' => 'location',
            'title' => 'title',
            'company' => [
                'id' => '?'
            ]
        ];

        $this->client->request('POST', '/api/jobs', $data);
        $this->assertResponseCode($this->response(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function it_creates_job_and_new_company()
    {
        $this->loadFixtures('user');
        $this->logUserIn('bog@igra.com', 'bogigre');

        $data = [
            'description' => "Description",
            'website' => "Website",
            'location' => 'location',
            'title' => 'title',
            'company' => [
                'name' => 'The fucking best company!'
            ]
        ];

        $this->client->request('POST', '/api/jobs', $data);
        $this->assertResponseCode($this->response(), Response::HTTP_CREATED);
    }
}
