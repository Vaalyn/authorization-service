<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Authorizer;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Vaalyn\AuthorizationService\AuthorizationUserInterface;

class AdminAuthorizer implements AuthorizerInterface {
	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->databaseManager = $container->database;
	}

	/**
	 * @inheritDoc
	 */
	public function isAuthorized(?AuthorizationUserInterface $user, ?Request $request): bool {
		return $user->getIsAdmin();
	}
}
