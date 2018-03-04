<?php

namespace App\Controller\Job;

use App\Controller\BaseAction;
use App\Factory\JobViewFactory;
use App\Factory\PageViewFactory;
use App\Repository\JobRepository;
use App\Util\PaginatorDetails;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

class ShowJobsAction extends BaseAction
{
    /**
     * @var PageViewFactory
     */
    private $pageViewFactory;

    public function __construct(PageViewFactory $pageViewFactory)
    {
        $this->pageViewFactory = $pageViewFactory;
    }

    /**
     * @param JobRepository $jobRepository
     * @param JobViewFactory $jobViewFactory
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function __invoke(JobRepository $jobRepository, JobViewFactory $jobViewFactory, Request $request)
    {
        $search = $request->get('search');
        $remote = $request->get('remote');

        $paginatorDetails = new PaginatorDetails($request->attributes->get('_route'), $request->query->all());
        $queryBuilder = $jobRepository->createJobListQueryBuilder($search, $remote);

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));

        $pagerfanta->setMaxPerPage($paginatorDetails->limit());
        $pagerfanta->setCurrentPage($paginatorDetails->page());

        $pageView = $this->pageViewFactory->create($pagerfanta, $paginatorDetails->route(), $paginatorDetails->parameters());

        foreach ($pagerfanta->getCurrentPageResults() as $currentPageResult) {
            $pageView->items[] = $jobViewFactory->create($currentPageResult);
        }

        return $this->createView($pageView);
    }
}
