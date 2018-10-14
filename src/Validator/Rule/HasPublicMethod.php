<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Validator\Rule;

use Respect\Validation\Rules\AbstractRelated;
use Respect\Validation\Validatable;
use Vaalyn\AuthorizationService\Exception\HasPublicMethodRuleException;

class HasPublicMethod extends AbstractRelated {
	/**
	 * @param string $reference
	 * @param Validatable $validator
	 * @param bool $mandatory
	 */
	public function __construct(string $reference, Validatable $validator = null, bool $mandatory = true) {
        parent::__construct($reference, $validator, $mandatory);
    }

	/**
	 * @param mixed $input
	 *
	 * @return mixed
	 */
    public function getReferenceValue($input) {
        return $input->{$this->reference}();
    }

	/**
	 * @param mixed $input
	 *
	 * @return bool
	 */
    public function hasReference($input): bool {
		if (!is_object($input)) {
			return false;
		}

		if (!method_exists($input, $this->reference)) {
			return false;
		}

		if (!is_callable([$input, $this->reference])) {
			return false;
		}

        return true;
    }

	/**
	 * @return
	 */
	protected function createException(): HasPublicMethodRuleException {
        return new HasPublicMethodRuleException();
    }
}
