<?php

namespace App\Tests\Actions;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Tests\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class CompanyCreateActionTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_creates_company()
    {
        $this->loadFixtures('user');
        $this->logUserIn('bog@igra.com', 'bogigre');

        $data = [
            'name' => "Company name",
            'slogan' => "Company slogan"
        ];

        $this->client->request('POST', '/api/company', $data);
        $this->assertResponseCode($this->response(), Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_updates_comapany_details()
    {
        $this->loadFixtures('user');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var CompanyRepository $userRepository */
        $companyRepository =$this->getEntityManager()->getRepository(Company::class);
        $company = $companyRepository->findOneBy(['name' => 'Facebook']);

        $data = [
            'name' => "Company name",
            'slogan' => "Company slogan"
        ];

        $this->client->request('POST', sprintf('/api/company/%s', $company->getId()), $data);

        $this->assertResponse($this->response(), 'company/show_updated_company', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_update_company_details_of_another_user()
    {
        $this->loadFixtures('user');
        $this->logUserIn('bog@igra.com', 'bogigre');

        /** @var CompanyRepository $userRepository */
        $companyRepository =$this->getEntityManager()->getRepository(Company::class);
        $company = $companyRepository->findOneBy(['name' => 'Tesla']);

        $data = [
            'name' => "Company name",
            'slogan' => "Company slogan"
        ];

        $this->client->request('POST', sprintf('/api/company/%s', $company->getId()), $data);

        $this->assertResponseCode($this->response(), Response::HTTP_UNAUTHORIZED);
    }
}
