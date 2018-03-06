<?php

namespace App\Factory;

use App\Entity\Job;
use App\View\JobView;
use Carbon\Carbon;

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
        $jobView->expiresAt = $job->getExpirationDate();
        $jobView->expiredDateForHumans = (Carbon::instance($job->getExpirationDate()))->diffForHumans();
        $jobView->active = $job->isActive();
        $jobView->renewed = $job->isRenewed();
        $jobView->refunded = $job->isRefunded();
        $jobView->company = $this->companyViewFactory->create($job->getCompany());

        return $jobView;
    }
}
