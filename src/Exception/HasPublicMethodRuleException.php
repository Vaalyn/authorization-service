<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Exception;

use Respect\Validation\Exceptions\NestedValidationException;

class HasPublicMethodRuleException extends NestedValidationException {
    public const NOT_PRESENT = 0;
    public const INVALID = 1;

    public static $defaultTemplates = [
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
	 * @return int
	 */
    public function chooseTemplate(): int {
        return $this->getParam('hasReference') ? static::INVALID : static::NOT_PRESENT;
    }
}
