<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Vaalyn\AuthorizationService\Transformer\AuthorizationUserTransformer;

class Authorization implements AuthorizationInterface {
	/**
	 * @var AuthorizerFactory
	 */
	protected $authorizerFactory;

	/**
	 * @var AuthorizationUserTransformer
	 */
	protected $authorizationUserTransformer;

	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @var array
	 */
	protected $routesWithAuthorization;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authorizerFactory            = new AuthorizerFactory($container->config['authorization']['authorizers'], $container);
		$this->authorizationUserTransformer = new AuthorizationUserTransformer();
		$this->container                    = $container;
		$this->routesWithAuthorization      = $container->config['authorization']['routes'];
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
			$authorizer = $this->authorizerFactory->create($authorizerType, $this->container);

			if ($authorizer->isAuthorized($authorizationUser, $request)) {
				return true;
			}
		}

		return false;
	}
}
