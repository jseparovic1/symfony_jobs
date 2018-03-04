<?php

namespace App\ViewRepository;


use App\Factory\JobViewFactory;
use App\Factory\PageViewFactory;
use App\Repository\JobRepository;
use App\Util\PaginatorDetails;
use App\View\Pagination\PageView;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class JobsViewRepository
{
    /**
     * @var JobViewFactory
     */
    private $jobViewFactory;

    /**
     * @var PageViewFactory
     */
    private $pageViewFactory;

    /**
     * @var JobRepository
     */
    private $jobRepository;

    public function __construct(
        JobViewFactory $jobViewFactory,
        PageViewFactory $pageViewFactory,
        JobRepository $jobRepository
    ) {
        $this->jobViewFactory = $jobViewFactory;
        $this->pageViewFactory = $pageViewFactory;
        $this->jobRepository = $jobRepository;
    }

    /**
     * @param $request
     * @return PageView
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function findAllJobs($request, $search, $remote): PageView
    {
        $paginatorDetails = new PaginatorDetails($request->attributes->get('_route'), $request->query->all());
        $queryBuilder = $this->jobRepository->createJobListQueryBuilder($search, $remote);

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));

        $pagerfanta->setMaxPerPage($paginatorDetails->limit());
        $pagerfanta->setCurrentPage($paginatorDetails->page());

        $pageView = $this->pageViewFactory->create($pagerfanta, $paginatorDetails->route(), $paginatorDetails->parameters());

        foreach ($pagerfanta->getCurrentPageResults() as $currentPageResult) {
            $pageView->items[] = $this->jobViewFactory->create($currentPageResult);
        }

        return $pageView;
    }
}
