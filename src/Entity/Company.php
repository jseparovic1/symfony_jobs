<?php

namespace App\Entity;

use Gedmo\Timestampable\Traits\Timestampable;

/**
 * Class Company
 */
class Company implements ResourceInterface
{
    use Timestampable;

    /** @var mixed */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $logo;

    /** @var string */
    private $slogan;

    /** @var string */
    private $contactEmail;

    /** @var Agent */
    private $agent;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    /**
     * @param string $slogan
     */
    public function setSlogan(?string $slogan): void
    {
        $this->slogan = $slogan;
    }

    /**
     * @return string
     */
    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    /**
     * @param string $email
     */
    public function setContactEmail(string $email): void
    {
        $this->contactEmail = $email;
    }

    /**
     * @return Agent
     */
    public function getAgent(): Agent
    {
        return $this->agent;
    }

    /**
     * @param Agent $agent
     */
    public function setAgent(Agent $agent): void
    {
        $this->agent = $agent;
    }
}
