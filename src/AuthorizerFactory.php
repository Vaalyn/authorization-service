<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService;

use Psr\Container\ContainerInterface;
use Vaalyn\AuthorizationService\Authorizer\AuthorizerInterface;
use Vaalyn\AuthorizationService\Exception\UnknownAuthorizerException;

class AuthorizerFactory implements AuthorizerFactoryInterface {
	/**
	 * @var array
	 */
	protected $authorizers;

	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param array $authorizers
	 * @param ContainerInterface $container
	 */
	public function __construct(array $authorizers, ContainerInterface $container) {
		$this->authorizers = $authorizers;
		$this->container   = $container;
	}

	/**
	 * @inheritDoc
	 */
	public function create(string $authorizerType, ContainerInterface $container): AuthorizerInterface {
		if (!array_key_exists($authorizerType, $this->authorizers)) {
			throw new UnknownAuthorizerException(
				sprintf(
					'There is no known Authorizer of the type %s',
					$authorizerType
				)
			);
		}

		$authorizerClass = $this->authorizers[$authorizerType];

		$authorizer = new $authorizerClass($this->container);

		return $authorizer;
	}
}
