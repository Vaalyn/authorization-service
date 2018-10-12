<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Authorizer;

use Slim\Http\Request;
use Vaalyn\AuthorizationService\AuthorizationUserInterface;

interface AuthorizerInterface {
	/**
	 * @param AuthorizationUserInterface|null $user
	 * @param Request|null $request
	 *
	 * @return bool
	 */
	public function isAuthorized(?AuthorizationUserInterface $user, ?Request $request): bool;
}
