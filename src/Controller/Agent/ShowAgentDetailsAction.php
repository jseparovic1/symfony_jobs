<?php

namespace App\Controller\Agent;

use App\Controller\BaseAction;
use App\Entity\User;
use App\Factory\JobViewFactory;
use App\Repository\JobRepository;
use App\View\AgentView;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShowAgentDetailsAction extends BaseAction
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $agentView = new AgentView();
        $agentView->name = $user->getName();
        $agentView->email = $user->getEmailCanonical();
        $agentView->memberSince = $user->getCreatedAt();

        return $this->createView($agentView);
    }
}
