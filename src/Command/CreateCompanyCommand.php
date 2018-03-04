<?php

namespace App\Command;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateJobCommand
 */
class CreateCompanyCommand extends Command
{
    /** @var string */
    public $name;

    /** @var string */
    public $logo;

    /** @var UploadedFile|File */
    public $slogan;

    /** @var User */
    public $agent;

    public function __construct(Request $request, User $agent)
    {
        $this->name = $request->request->get('name');
        $this->logo = $request->files->get('logo');
        $this->slogan = $request->request->get('slogan');
        $this->agent = $agent;
    }
}
