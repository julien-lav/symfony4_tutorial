<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;


class UserManager 
{

	private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserByEmail(string $email): ?User
    {
    	return $this->userRepository->findOneBy(['email' => $email]);
    }

    public function getUserByFirstname(string $firstName): ?array
    {
    	return $this->userRepository->findBy(['firstname' => $firstname], ['firstname' => 'ASC']);
    }
    public function getUserTotalArticles(string $email): ?int 
    {
    	return count($this->getUserByEmail($email)->getTutorials());
    }
}