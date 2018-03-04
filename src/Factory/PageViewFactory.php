<?php

namespace App\Factory;

use App\View\Pagination\PageLinksView;
use App\View\Pagination\PageView;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Routing\RouterInterface;

final class PageViewFactory
{
    /** @var RouterInterface */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function create(Pagerfanta $pagerfanta, string $route, array $parameters): PageView
    {
        /** @var PageView $page */
        $page = new PageView();
        $page->page = $pagerfanta->getCurrentPage();
        $page->limit = $pagerfanta->getMaxPerPage();
        $page->pages = $pagerfanta->getNbPages();
        $page->total = $pagerfanta->getNbResults();
        $page->links = new PageLinksView();
        $page->links->self = $this->router->generate($route, array_merge($parameters, [
            'page' => $pagerfanta->getCurrentPage(),
            'limit' => $pagerfanta->getMaxPerPage(),
        ]));
        $page->links->first = $this->router->generate($route, array_merge($parameters, [
            'page' => 1,
            'limit' => $pagerfanta->getMaxPerPage(),
        ]));
        $page->links->last = $this->router->generate($route, array_merge($parameters, [
            'page' => $pagerfanta->getNbPages(),
            'limit' => $pagerfanta->getMaxPerPage(),
        ]));
        $page->links->next = $this->router->generate($route, array_merge($parameters, [
            'page' => ($pagerfanta->getCurrentPage() < $pagerfanta->getNbPages()) ? $pagerfanta->getCurrentPage() + 1 : $pagerfanta->getCurrentPage(),
            'limit' => $pagerfanta->getMaxPerPage(),
        ]));

        return $page;
    }
}
