<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Validator\Exceptions;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Exceptions\NonOmissibleException;

class HasPublicMethodException extends NestedValidationException implements NonOmissibleException {
	public const NOT_PRESENT = 'not_present';
	public const INVALID = 'invalid';

	/**
	 * @var array
	 */
	protected $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::NOT_PRESENT => 'Method {{name}} must be present',
			self::INVALID => 'Method {{name}} must be valid',
		],
		self::MODE_NEGATIVE => [
			self::NOT_PRESENT => 'Method {{name}} must not be present',
			self::INVALID => 'Method {{name}} must not validate',
		],
	];

	/**
	 * @return string
	 */
	protected function chooseTemplate(): string {
		return $this->getParam('hasReference') ? self::INVALID : self::NOT_PRESENT;
	}
}
