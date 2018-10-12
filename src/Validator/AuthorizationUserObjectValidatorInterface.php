<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Validator;

interface AuthorizationUserObjectValidatorInterface {
	/**
	 * @param object $user
	 *
	 * @return void
	 */
	public function validate(object $user): void;
}
