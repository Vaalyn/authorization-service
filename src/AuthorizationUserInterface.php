<?php

declare(strict_types = 1);

namespace Vaalyn\AuthorizationService;

interface AuthorizationUserInterface {
	/**
	 * @return int
	 */
	public function getUserId(): int;

	/**
	 * @param int $userId
	 *
	 * @return AuthorizationUserInterface
	 */
	public function setUserId(int $userId): AuthorizationUserInterface;

	/**
	 * @return string
	 */
	public function getUsername(): string;

	/**
	 * @param string $username
	 *
	 * @return AuthorizationUserInterface
	 */
	public function setUsername(string $username): AuthorizationUserInterface;

	/**
	 * @return string
	 */
	public function getEmail(): string;

	/**
	 * @param string $email
	 *
	 * @return AuthorizationUserInterface
	 */
	public function setEmail(string $email): AuthorizationUserInterface;

	/**
	 * @return bool
	 */
	public function getIsAdmin(): bool;

	/**
	 * @param bool $isAdmin
	 *
	 * @return AuthorizationUserInterface
	 */
	public function setIsAdmin(bool $isAdmin): AuthorizationUserInterface;
}
