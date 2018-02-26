<?php

namespace App\Controller;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseAction extends AbstractController
{
    /**
     * @var ViewHandlerInterface
     */
    protected $viewHandler;

    /**
     * @var CommandBus
     */
    protected $bus;

    public function __construct(ViewHandlerInterface $viewHandler, CommandBus $bus)
    {
        $this->viewHandler = $viewHandler;
        $this->bus = $bus;
    }

    /**
     * @param null $data
     * @param null $statusCode
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createView($data = null, $statusCode = null, array $headers = [])
    {
        return $this->viewHandler->handle(View::create($data, $statusCode, $headers));
    }
}
