<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService;

class AuthorizationUser implements AuthorizationUserInterface {
	/**
	 * @var int
	 */
	protected $userId;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * @var string
	 */
	protected $email;

	/**
	 * @var bool
	 */
	protected $isAdmin;

	/**
	 * @param int $userId
	 * @param string $username
	 * @param string $email
	 * @param bool $isAdmin
	 */
	public function __construct(int $userId, string $username, string $email, bool $isAdmin) {
		$this->setUserId($userId)
			->setUsername($username)
			->setEmail($email)
			->setIsAdmin($isAdmin);
	}

	/**
	 * @inheritDoc
	 */
	public function getUserId(): int {
		return $this->userId;
	}

	/**
	 * @inheritDoc
	 */
	public function setUserId(int $userId): AuthorizationUserInterface {
		$this->userId = $userId;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getUsername(): string {
		return $this->username;
	}

	/**
	 * @inheritDoc
	 */
	public function setUsername(string $username): AuthorizationUserInterface {
		$this->username = $username;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getEmail(): string {
		return $this->email;
	}

	/**
	 * @inheritDoc
	 */
	public function setEmail(string $email): AuthorizationUserInterface {
		$this->email = $email;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getIsAdmin(): bool {
		return $this->isAdmin;
	}

	/**
	 * @inheritDoc
	 */
	public function setIsAdmin(bool $isAdmin): AuthorizationUserInterface {
		$this->isAdmin = $isAdmin;

		return $this;
	}
}
