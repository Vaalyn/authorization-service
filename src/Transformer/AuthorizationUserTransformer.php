<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Transformer;

use Respect\Validation\Exceptions\NestedValidationException;
use Vaalyn\AuthorizationService\AuthorizationUser;
use Vaalyn\AuthorizationService\Exception\UserValidationFailedException;
use Vaalyn\AuthorizationService\Validator\AuthorizationUserObjectValidator;

class AuthorizationUserTransformer {
	/**
	 * @param object $user
	 *
	 * @return AuthorizationUser
	 */
	public function transformObjectToAuthorizationUser(object $user): AuthorizationUser {
		$authorizationUserObjectValidator = new AuthorizationUserObjectValidator();

		try {
			$authorizationUserObjectValidator->validate($user);
		} catch (NestedValidationException $exception) {
			$excpetionMessage = sprintf(
				'User validation for %s failed because of the following reasons: %s',
				self::class,
				implode(', ', $exception->getMessages())
			);

			throw new UserValidationFailedException($excpetionMessage);
		}

		return new AuthorizationUser(
			$user->getUserId(),
			$user->getUsername(),
			$user->getEmail(),
			$user->getIsAdmin()
		);
	}
}
