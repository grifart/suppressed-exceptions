<?php declare(strict_types=1);


namespace Grifart\SuppressedExceptions;

/**
 * Provides interface similar to Java suppressed exceptions.
 *
 * @link https://docs.oracle.com/javase/7/docs/api/java/lang/Throwable.html#addSuppressed(java.lang.Throwable)
 */
interface WithSuppressedExceptions
{

	/**
	 * Appends the specified exception to the exceptions that were suppressed in order to deliver this exception.
	 *
	 * Note that when one exception causes another exception, the first exception is usually caught and then the second exception is thrown in response.
	 * In other words, there is a causal connection between the two exceptions.
	 * In contrast, there are situations where two independent exceptions can be thrown in sibling code blocks.
	 * In these situations, only one of the thrown exceptions can be propagated.
	 *
	 * An exception may have suppressed exceptions while also being caused by another exception.
	 * Whether or not an exception has a cause is semantically known at the time of its creation,
	 * unlike whether or not an exception will suppress other exceptions which is typically only determined
	 * after an exception is thrown.
	 *
	 * Note that programmer written code is also able to take advantage of calling this method in situations
	 * where there are multiple sibling exceptions and only one can be propagated.
	 *
	 * @param \Throwable $e the exception to be added to the list of suppressed exceptions
	 */
	public function addSuppressed(\Throwable $e): void;

	/**
	 * Returns an array containing all of the exceptions that were suppressed.
	 * If no exceptions were suppressed, an empty array is returned.
	 * This method is thread-safe. Writes to the returned array do not affect future calls to this method.
	 *
     * @return \Throwable|array an array containing all of the exceptions that were suppressed to deliver this exception.
	 */
	public function getSuppressed(): array;

}