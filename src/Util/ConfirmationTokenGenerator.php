<?php

namespace App\Util;

use App\Repository\UserRepository;

class ConfirmationTokenGenerator
{
    /**
     * @var
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $size
     * @return string
     */
    public function generate($size = 5)
    {
        do {
            $token = Str::random($size);
        } while (count($this->userRepository->findBy(['confirmationToken' => $token])) === 1);

        return $token;
    }
}
