<?php

namespace App\Controller\Company;

use App\Command\SaveEntityCommand;
use App\Command\UpdateEntityCommand;
use App\Controller\BaseAction;
use App\Entity\Company;
use App\Factory\CompanyViewFactory;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditCompanyAction extends BaseAction
{
    /**
     * @var CompanyViewFactory
     */
    private $companyViewFactory;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    public function __construct(
        CompanyViewFactory $companyViewFactory,
        TokenStorageInterface $tokenStorage,
        CompanyRepository $companyRepository
    ) {
        $this->companyViewFactory = $companyViewFactory;
        $this->tokenStorage = $tokenStorage;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request)
    {
        $company = $this->bus->handle(new UpdateEntityCommand(
            Company::class,
            $request->attributes->get('id'),
            $request->request->all(),
            ['name', 'slogan']
        ));

        $this->validateUserIsOwner($company);
        $saveCompanyCommand = new SaveEntityCommand($company);

        if ($logo = $request->files->get('logo')) {
            dump("stavljam logo hehiehiehiehiehiehiehi");
            $company->setLogoFile($logo);
            $saveCompanyCommand->addValidationGroup('logo');
        }

        $company = $this->bus->handle($saveCompanyCommand);

        return $this->createView($this->companyViewFactory->create($company));
    }

    /**
     * @param $company
     */
    public function validateUserIsOwner(Company $company): void
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if ($company->getAgent()->getId() !== $user->getId()) {
            throw new UnauthorizedHttpException('', "You don't own this resource!");
        }
    }
}
