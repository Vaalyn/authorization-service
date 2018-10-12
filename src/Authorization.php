<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Vaalyn\AuthorizationService\Transformer\AuthorizationUserTransformer;

class Authorization implements AuthorizationInterface {
	/**
	 * @var array
	 */
	protected $routesWithAuthorization;

	/**
	 * @var AuthorizerFactory
	 */
	protected $authorizerFactory;

	/**
	 * @var AuthorizationUserTransformer
	 */
	protected $authorizationUserTransformer;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->routesWithAuthorization      = $container->config['authorization']['routes'];
		$this->authorizerFactory            = new AuthorizerFactory($container->config['authorization']['authorizers'], $container);
		$this->authorizationUserTransformer = new AuthorizationUserTransformer();
	}

	/**
	 * @inheritDoc
	 */
	public function needsAuthorizationForRoute(string $routeName): bool {
		return array_key_exists($routeName, $this->routesWithAuthorization);
	}

	/**
	 * @inheritDoc
	 */
	public function hasAuthorizationForRoute(?object $user, string $routeName, Request $request): bool {
		if (!$this->needsAuthorizationForRoute($routeName)) {
			return true;
		}

		$authorizationUser = null;

		if ($user !== null) {
			$authorizationUser = $this->authorizationUserTransformer->transformObjectToAuthorizationUser($user);
		}

		foreach ($this->routesWithAuthorization[$routeName] as $authorizerType) {
			$authorizer = $this->authorizerFactory->create($authorizerType);

			if ($authorizer->isAuthorized($authorizationUser, $request)) {
				return true;
			}
		}

		return false;
	}
}
