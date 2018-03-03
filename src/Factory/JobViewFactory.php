<?php

namespace App\Factory;

use App\Entity\Job;
use App\View\JobView;

final class JobViewFactory
{
    /**
     * @var CompanyViewFactory
     */
    private $companyViewFactory;

    public function __construct(CompanyViewFactory $companyViewFactory)
    {
        $this->companyViewFactory = $companyViewFactory;
    }

    public function create(Job $job): JobView
    {
        $jobView = new JobView();

        $jobView->id = $job->getId();
        $jobView->description = $job->getDescription();
        $jobView->website = $job->getWebsite();
        $jobView->location = $job->getLocation();
        $jobView->remote = $job->isRemote();
        $jobView->title = $job->getTitle();
        $jobView->slug = $job->getSlug();
        $jobView->createdAt = $job->getCreatedAt();
        $jobView->company = $this->companyViewFactory->create($job->getCompany());

        return $jobView;
    }
}
