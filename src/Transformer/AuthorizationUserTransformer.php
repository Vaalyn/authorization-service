<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Transformer;

use Vaalyn\AuthorizationService\AuthorizationUser;
use Vaalyn\AuthorizationService\Validator\AuthorizationUserObjectValidator;

class AuthorizationUserTransformer {
	/**
	 * @param object $user
	 *
	 * @return AuthorizationUser
	 */
	public function transformObjectToAuthorizationUser(object $user): AuthorizationUser {
		$authorizationUserObjectValidator = new AuthorizationUserObjectValidator();
		$authorizationUserObjectValidator->validate($user);

		return new AuthorizationUser(
			$user->getUserId(),
			$user->getUsername(),
			$user->getEmail(),
			$user->getIsAdmin()
		);
	}
}
