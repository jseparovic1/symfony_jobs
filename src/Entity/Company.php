<?php

namespace App\Entity;

use Gedmo\Timestampable\Traits\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Class Company
 * @Vich\Uploadable
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

    /**
     * @var UploadedFile
     * @Vich\UploadableField(mapping="logos", fileNameProperty="logo")
     */
    private $logoFile;

    /** @var string */
    private $slogan;

    /** @var User */
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
     * @return User
     */
    public function getAgent(): ?User
    {
        return $this->agent;
    }

    /**
     * @param User $agent
     */
    public function setAgent(User $agent): void
    {
        $this->agent = $agent;
    }

    /**
     * @return UploadedFile|File
     */
    public function getLogoFile(): ?UploadedFile
    {
        return $this->logoFile;
    }

    /**
     * @param UploadedFile|File $logoFile
     */
    public function setLogoFile(?File $logoFile): void
    {
        $this->logoFile = $logoFile;

        if (null !== $logoFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }
}
