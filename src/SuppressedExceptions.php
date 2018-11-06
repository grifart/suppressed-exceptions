<?php declare(strict_types=1);


namespace Grifart\SuppressedExceptions;

/**
 * Simple implementation of WithSuppressedExceptions interface
 */
trait SuppressedExceptions /* implements WithSuppressedExceptions */
{

	private $suppressedExceptions = [];

	public function addSuppressed(\Throwable $e): void
	{
		$this->suppressedExceptions[] = $e;
	}

	public function getSuppressed(): array
	{
		return $this->suppressedExceptions;
	}

}