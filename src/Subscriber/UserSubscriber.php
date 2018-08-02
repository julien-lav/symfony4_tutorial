<?php

namespace App\Subscriber;
use App\Event\UserRegisteredEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
	private $logger;

	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	public static function getSubscribedEvents()
	{
		return [ UserRegisteredEvent::NAME => 'onUserRegisterdEvent',];
	}

	public function onUserRegisterdEvent(UserRegisteredEvent $userRegisteredEvent)
	{
		$user = $userRegisteredEvent->getUser();
		$this->logger->info('user register', ['email'=> $user->getEmail()]);
    	
	}
}