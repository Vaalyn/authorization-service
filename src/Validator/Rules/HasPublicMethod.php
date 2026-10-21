<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService\Validator\Rules;

use Respect\Validation\Rules\AbstractRelated;
use Respect\Validation\Validatable;

class HasPublicMethod extends AbstractRelated {
	/**
	 * @param string $reference
	 * @param Validatable|null $rule
	 * @param bool $mandatory
	 */
	public function __construct(string $reference, ?Validatable $rule = null, bool $mandatory = true) {
		parent::__construct($reference, $rule, $mandatory);
	}

	/**
	 * @param mixed $input
	 *
	 * @return mixed
	 */
	public function getReferenceValue($input) {
		return $input->{$this->getReference()}();
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

		if (!method_exists($input, $this->getReference())) {
			return false;
		}

		if (!is_callable([$input, $this->getReference()])) {
			return false;
		}

		return true;
	}
}
