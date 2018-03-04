<?php

namespace App\EventSubscriber;

use App\Event\UserEvent;
use App\Util\Sender;
use App\Util\UserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegisterSubscriber  implements EventSubscriberInterface
{
    /**
     * @var Sender
     */
    private $sender;

    /**
     * @var string
     */
    private $frontendUrl;

    public function __construct(Sender $sender, string $frontendUrl)
    {
        $this->sender = $sender;
        $this->frontendUrl = $frontendUrl;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            UserEvents::USER_REGISTER => [['sendActivationEmail']],
        ];
    }

    /**
     * @param UserEvent $event
     */
    public function sendActivationEmail(UserEvent $event)
    {
        $user = $event->getUser();

        $this->sender->sendEmail(
            'emails/userActivation.html.twig',
            'Account activation @symfonyjobs.io',
            $user->getEmailCanonical(), [
                'name' => $user->getName(),
                'code' => $user->getConfirmationToken(),
                'frontendUrl' => $this->frontendUrl
            ]
        );
    }
}
