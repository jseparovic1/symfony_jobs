<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateJobCommand
 */
class CreateJobCommand extends Command
{
    /** @var string */
    public $description;

    /** @var string */
    public $title;

    /** @var string */
    public $website;

    /** @var string */
    public $location;

    /** @var bool */
    public $remote;

    /** @var string */
    public $companyName;

    /** @var string */
    public $companyLogo;

    /** @var string */
    public $companySlogan;

    /** @var string */
    public $companyEmail;

    /** @var array */
    public $company;

    /** @var mixed */
    public $companyId;

    /** @var User */
    public $user;

    public function __construct(Request $request, User $user)
    {
        $this->description = $request->request->get('description');
        $this->website = $request->request->get('website');
        $this->location = $request->request->get('location');
        $this->remote = $request->request->get('remote');
        $this->title = $request->request->get('title');

        $this->company = $request->request->get('company');
        if ($this->company !== null) {
            $this->companyId = $this->getCompanyValue('id');
            $this->companyName = $this->getCompanyValue('name');
            $this->companySlogan = $this->getCompanyValue('slogan');
            $this->companyLogo = $this->getCompanyValue('logo');
            $this->companyEmail = $this->getCompanyValue('contactEmail');
        }

        $this->user = $user;
    }

    private function getCompanyValue($key)
    {
        return array_key_exists($key, $this->company) ? $this->company[$key] : null;
    }
}
