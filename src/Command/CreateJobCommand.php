<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

    /** @var UploadedFile */
    public $companyLogo;

    /** @var string */
    public $companySlogan;

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
        $this->remote = (bool)$request->request->get('remote');
        $this->title = $request->request->get('title');

        $this->company = $request->request->get('company');

        if ($this->company !== null) {
            $this->companyId = $this->getCompanyValue('id');
            $this->companyName = $this->getCompanyValue('name');
            $this->companySlogan = $this->getCompanyValue('slogan');
            $this->companyLogo = $this->getLogo($request->files->get('company'));
        }

        $this->user = $user;
    }

    private function getCompanyValue($key)
    {
        return array_key_exists($key, $this->company) ? $this->company[$key] : null;
    }

    private function getLogo($files)
    {
        if (!is_array($files)){
            return null;
        }

        return array_key_exists('logo', $files) ? $files['logo'] : null;
    }
}
