<?php

namespace App\Controller\Job;

use App\Command\SaveEntityCommand;
use App\Command\UpdateEntityCommand;
use App\Controller\BaseAction;
use App\Entity\Job;
use App\Factory\JobViewFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditJobAction extends BaseAction
{
    /**
     * @param Request $request
     * @param JobViewFactory $jobViewFactory
     * @param TokenStorageInterface $tokenStorage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, JobViewFactory $jobViewFactory, TokenStorageInterface $tokenStorage)
    {
        /** @var Job $job */
        $job = $this->bus->handle(new UpdateEntityCommand(
            Job::class,
            $request->attributes->get('id'),
            $request->request->all(),
            ['description', 'website', 'location', 'title', 'remote']
        ));

        $user = $tokenStorage->getToken()->getUser();
        if ($job->getCompany()->getAgent()->getId() !== $user->getId()) {
            throw new UnauthorizedHttpException('', "You don't own this resource!");
        }

        $job = $this->bus->handle(new SaveEntityCommand($job));
        return $this->createView($jobViewFactory->create($job));
    }
}
