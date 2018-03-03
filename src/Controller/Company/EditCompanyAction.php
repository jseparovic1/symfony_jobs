<?php

namespace App\Controller\Company;

use App\Command\SaveEntityCommand;
use App\Command\UpdateEntityCommand;
use App\Controller\BaseAction;
use App\Entity\Company;
use App\Factory\CompanyViewFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditCompanyAction extends BaseAction
{
    /**
     * @param Request $request
     * @param CompanyViewFactory $companyViewFactory
     * @param TokenStorageInterface $tokenStorage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, CompanyViewFactory $companyViewFactory, TokenStorageInterface $tokenStorage)
    {
        /** @var Company $company */
        $company = $this->bus->handle(new UpdateEntityCommand(
            Company::class,
            $request->attributes->get('id'),
            $request->request->all(),
            ['name', 'slogan']
        ));

        $user = $tokenStorage->getToken()->getUser();
        if ($company->getAgent()->getId() !== $user->getId()) {
            throw new UnauthorizedHttpException('', "You don't own this resource!");
        }

        $company = $this->bus->handle(new SaveEntityCommand($company));

        return $this->createView($companyViewFactory->create($company));
    }
}
