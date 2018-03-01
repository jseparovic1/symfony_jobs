<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateJobCommand
 */
class CreateJobCommand
{
    /** @var string */
    public $description;

    /** @var string */
    public $website;

    /** @var string */
    public $location;

    /** @var bool */
    public $remote;

    /** @var string */
    public $title;

    public function __construct(Request $request)
    {
        $this->description = $request->request->get('description');
        $this->website = $request->request->get('website');
        $this->location = $request->request->get('location');
        $this->remote = $request->request->get('remote');
        $this->title = $request->request->get('title');
    }
}
