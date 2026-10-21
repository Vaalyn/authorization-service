<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Validator;

use Respect\Validation\Validator;
use Vaalyn\AuthorizationService\Validator\Rules\HasPublicMethod;

class AuthorizationUserObjectValidator implements AuthorizationUserObjectValidatorInterface {
	/**
	 * @inheritDoc
	 */
	public function validate(object $user): void {
		(new Validator(
			new HasPublicMethod('getUserId', Validator::intType()),
			new HasPublicMethod('getUsername', Validator::stringType()),
			new HasPublicMethod('getEmail', Validator::stringType()),
			new HasPublicMethod('getIsAdmin', Validator::boolType())
		))->assert($user);
	}
}
