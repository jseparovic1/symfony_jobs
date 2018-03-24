<?php

namespace App\Entity;

use Gedmo\Timestampable\Traits\Timestampable;

class Job implements ResourceInterface
{
    use Timestampable;

    const STATE_CREATED = 'created';
    const STATE_ACTIVE = 'active';
    const STATE_EXPIRED = 'expired';
    const STATE_REFUNDED = 'refunded';
    const STATE_FULFILLED = 'fulfilled';

    /** @var mixed */
    private $id;

    /** @var string */
    private $description;

    /** @var string */
    private $website;

    /** @var string */
    private $location;

    /** @var bool */
    private $remote;

    /** @var string */
    private $title;

    /** @var string */
    private $slug;

    /** @var \DateTime */
    private $expirationDate;

    /** @var bool */
    private $renewed = false;

    /** @var string */
    private $status = self::STATE_CREATED;

    /** @var Company */
    private $company;

    /** @var User */
    private $author;

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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    /**
     * @return string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return bool
     */
    public function isRemote(): ?bool
    {
        return $this->remote;
    }

    /**
     * @param bool $remote
     */
    public function setRemote(bool $remote): void
    {
        $this->remote = $remote;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return Company
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany(?Company $company): void
    {
        $this->company = $company;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate(): \DateTime
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $expirationDate
     */
    public function setExpirationDate(\DateTime $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * @return bool
     */
    public function isRenewed(): bool
    {
        return $this->renewed;
    }

    /**
     * @param bool $renewed
     */
    public function setRenewed(bool $renewed): void
    {
        $this->renewed = $renewed;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }
}
