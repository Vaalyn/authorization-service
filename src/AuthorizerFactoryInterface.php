<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService;

use Psr\Container\ContainerInterface;
use Vaalyn\AuthorizationService\Authorizer\AuthorizerInterface;

interface AuthorizerFactoryInterface {
	/**
	 * @param string $authorizerType
	 * @param ContainerInterface $container
	 *
	 * @return AuthorizerInterface
	 */
	public function create(string $authorizerType, ContainerInterface $container): AuthorizerInterface;
}
