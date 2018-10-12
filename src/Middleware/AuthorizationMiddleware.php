<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Middleware;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;
use Vaalyn\AuthorizationService\AuthorizationInterface;

class AuthorizationMiddleware {
	/**
	 * @var RouterInterface
	 */
	protected $router;

	/**
	 * @var AuthorizationInterface
	 */
	protected $authorization;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authorization = $container->authorization;
		$this->router        = $container->router;
    }

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param callable $next
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, callable $next): Response {
		$currentRoute = $request->getAttribute('route');

		if ($currentRoute === null) {
			return $next($request, $response);
		}

		$currentRouteName = $currentRoute->getName();

		if (!$this->authorization->needsAuthorizationForRoute($currentRouteName)) {
			return $next($request, $response);
		}

		$user = $request->getAttribute('current_user');

		if (!$this->authorization->hasAuthorizationForRoute($user, $currentRouteName, $request)) {
			return $response->withStatus(400)
				->withHeader('Content-Type', 'application/json')
				->write(json_encode(array(
					'status' => 'error',
					'message' => 'the requested resource is not available for you'
				)));
		}

		return $next($request, $response);
	}
}
