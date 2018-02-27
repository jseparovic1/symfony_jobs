<?php

namespace App\Controller\Job;

use App\Controller\BaseAction;
use App\Repository\JobRepository;

class ShowJobsAction extends BaseAction
{
    public function __invoke()
    {
        $data = [
            "jobs1" => [
                'madarska' => 'penis'
            ],
            "jobs3" => [
                'madarska' => 'penis'
            ],
            "jobs4" => [
                'madarska' => 'penis'
            ],
            "jobs5" => [
                'madarska' => 'penis'
            ],
        ];

        return $this->createView($data);
    }
}
