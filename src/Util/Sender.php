<?php

namespace App\Util;

use Symfony\Component\Templating\EngineInterface;
use Twig\Error\Error;

class Sender
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    private $fromEmail;

    /**
     * @var EngineInterface
     */
    private $templatingEngine;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templatingEngine, string $fromEmail)
    {
        $this->mailer = $mailer;
        $this->fromEmail = $fromEmail;
        $this->templatingEngine = $templatingEngine;
    }

    /**
     * @param string $template
     * @param string $subject
     * @param string $to
     * @param array $data
     * @param $fromEmail
     * @param null $fromName
     */
    public function sendEmail(string $template, string $subject, string $to, array $data, $fromEmail = null, $fromName = null)
    {
            $message = (new \Swift_Message())
                ->setSubject($subject)
                ->setFrom($fromEmail ?? $this->fromEmail, $fromName)
                ->setTo($to)
                ->setBody($this->templatingEngine->render($template, $data), 'text/html');

        $this->mailer->send($message);
    }
}
