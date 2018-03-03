<?php

namespace App\View;

class JobView
{
    /** @var mixed */
    public $id;

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

    /** @var string */
    public $slug;

    /** @var \DateTime */
    public $createdAt;

    /** @var CompanyView */
    public $company;
}
