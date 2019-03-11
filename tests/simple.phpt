<?php declare(strict_types=1);

namespace Grifart\SuppressedExceptions\__tests;

use Grifart\SuppressedExceptions\SuppressedExceptions;
use Grifart\SuppressedExceptions\WithSuppressedExceptions;
use Symfony\Component\Console\Exception\RuntimeException;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

class TestingSuppressedExceptionsException extends \RuntimeException implements WithSuppressedExceptions
{
	use SuppressedExceptions;

}

$previous = new TestingSuppressedExceptionsException('previous', -1, new RuntimeException());
$exception = new TestingSuppressedExceptionsException('message', 42, $previous);

$exception->addSuppressed($suppressed1 = new \RuntimeException());
$exception->addSuppressed($suppressed2 = new \LogicException('This is message'));
$exception->addSuppressed($suppressed3 = new \Error());
$exception->addSuppressed($suppressed4 = new \Exception('With previous', 0, $previous));
$exception->addSuppressed($suppressed5 = new TestingSuppressedExceptionsException());

// test that can be thrown
Assert::exception(
	function() use ($exception) {
		throw $exception;
	},
	TestingSuppressedExceptionsException::class,
	\file_get_contents(__DIR__ . '/simple_exception-message.txt')
);

// previous
Assert::same($previous, $exception->getPrevious());

// suppressed exceptions
Assert::same(
	[$suppressed1, $suppressed2, $suppressed3, $suppressed4, $suppressed5],
	$exception->getSuppressed()
);

