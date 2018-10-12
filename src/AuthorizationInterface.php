<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService;

use Slim\Http\Request;

interface AuthorizationInterface {
	/**
	 * @param string $routeName
	 *
	 * @return bool
	 */
	public function needsAuthorizationForRoute(string $routeName): bool;

	/**
	 * @param object|null $user
	 * @param string $routeName
	 * @param Request $request
	 *
	 * @return bool
	 */
	public function hasAuthorizationForRoute(?object $user, string $routeName, Request $request): bool;
}
