<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateJobCommand
 */
class CreateCompanyCommand
{
    /** @var string */
    public $name;

    /** @var string */
    public $logo;

    /** @var string */
    public $slogan;

    /** @var bool */
    public $contactEmail;

    /** @var User */
    public $agent;

    public function __construct(Request $request, User $agent)
    {
        $this->name = $request->request->get('name');
        $this->logo = $request->request->get('logo');
        $this->slogan = $request->request->get('slogan');
        $this->contactEmail = $request->request->get('contactEmail');
        $this->agent = $agent;
    }
}
