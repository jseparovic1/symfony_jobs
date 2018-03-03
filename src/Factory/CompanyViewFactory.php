<?php

namespace App\Factory;

use App\Entity\Company;
use App\View\CompanyView;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

final class CompanyViewFactory
{
    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;

    public function __construct(UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

    public function create(Company $company): CompanyView
    {
        $companyView = new CompanyView();

        $companyView->id = $company->getId();
        $companyView->name = $company->getName();
        $companyView->slogan = $company->getSlogan();
        $companyView->logo =
            is_string($company->getLogo())
                ? '/logos/'. $company->getLogo()
                : null;

        return $companyView;
    }
}
