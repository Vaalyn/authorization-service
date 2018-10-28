<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Authorizer;

use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Vaalyn\AuthorizationService\AuthorizationUserInterface;

class AuthorizationTokenAuthorizer implements AuthorizerInterface {
	public const AUTHORIZATION_TOKEN_PARAMETER = 'authorizationToken';

	/**
	 * @var Manager
	 */
	protected $databaseManager;

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
		$authorizationTokenValue = $request->getQueryParam(self::AUTHORIZATION_TOKEN_PARAMETER);

		if ($authorizationTokenValue === null) {
			return false;
		}

		$authorizationTokens = $this->databaseManager
			->table('authorization_token')
			->get();

		foreach ($authorizationTokens as $authorizationToken) {
			if (!password_verify($authorizationTokenValue, $authorizationToken->token)) {
				continue;
			}

			$authorizedRoutes = $this->databaseManager
				->table('authorized_route')
				->where('authorization_token_id', '=', $authorizationToken->authorization_token_id)
				->get();

			foreach ($authorizedRoutes as $authorizedRoute) {
				if ($authorizedRoute->route_name === $this->getRouteNameFromRequest($request)) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	protected function getRouteNameFromRequest(Request $request): string {
		$currentRoute = $request->getAttribute('route');

		if ($currentRoute === null) {
			return '';
		}

		return $currentRoute->getName();
	}
}
