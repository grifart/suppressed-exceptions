<?php declare(strict_types=1);


namespace Grifart\SuppressedExceptions;

/**
 * Simple implementation of WithSuppressedExceptions interface
 */
trait SuppressedExceptions /* implements WithSuppressedExceptions */
{

	private $suppressedExceptions = [];

	public function addSuppressed(\Throwable ...$exceptions): void
	{
		foreach($exceptions as $exception) {
			$this->suppressedExceptions[] = $exception;
		}
	}

	public function getSuppressed(): array
	{
		return $this->suppressedExceptions;
	}

}