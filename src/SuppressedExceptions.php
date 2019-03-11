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
			$this->addTextVersionOfExceptionToMessage($exception);
			$this->suppressedExceptions[] = $exception;
		}
	}

	public function getSuppressed(): array
	{
		return $this->suppressedExceptions;
	}

	private function addTextVersionOfExceptionToMessage(\Throwable $throwable): void
	{
		if ($this->suppressedExceptions === []) {
			$this->message .= "\nSuppressed exceptions:\n";
		}

		$moveRight = function(string $textToMoveRight, int $offset): string {
			$replaceWith = "\n" . \str_repeat(' ', $offset);
			return str_replace(
				["\r\n","\n","\r"],
				$replaceWith,
				$textToMoveRight
			);
		};

		$renderSingle = function(\Throwable $throwable): string {
			$message = $throwable->getMessage();
			$type = \get_class($throwable);
			$message =
				$message === ''
					? $type
					: "{$message} ({$type})";

			$fileRelativePath = str_replace(\getcwd() . DIRECTORY_SEPARATOR, '', $throwable->getFile());
			return "{$fileRelativePath}:{$throwable->getLine()} - {$message}";
		};

		$renderTree = function(\Throwable $throwable) use ($moveRight, $renderSingle): string {
			$string = $renderSingle($throwable);
			$previous = $throwable;
			while (($previous = $previous->getPrevious()) !== NULL) {
				$string .= "\n  previous: {$moveRight($renderSingle($previous), 12)}";
			}
			return $string;
		};

		$this->message .= "- {$moveRight($renderTree($throwable), 2)}\n";
	}

}
