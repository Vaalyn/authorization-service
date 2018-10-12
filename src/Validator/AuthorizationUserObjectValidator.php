<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Validator;

use Respect\Validation\Validator;

class AuthorizationUserObjectValidator implements AuthorizationUserObjectValidatorInterface {
	/**
	 * @inheritDoc
	 */
	public function validate(object $user): void {
		Validator::with('Vaalyn\\AuthorizationService\\Validator\\Rule');

		Validator::hasPublicMethod('getUserId', Validator::intType())
			->hasPublicMethod('getUsername', Validator::stringType())
			->hasPublicMethod('getEmail', Validator::stringType())
			->hasPublicMethod('getIsAdmin', Validator::boolType())
			->assert($user);
	}
}
