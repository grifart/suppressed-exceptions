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
$exception1 = new TestingSuppressedExceptionsException('message', 42, $previous);
$exception1->addSuppressed(new RuntimeException('message', 0, $previous));

$exception2 = new TestingSuppressedExceptionsException('message2', 42);
$exception2->addSuppressed($previous);
$exception2->addSuppressed($exception1);

Assert::exception(
	function() use ($exception2) {
		throw $exception2;
	},
	TestingSuppressedExceptionsException::class,
	\file_get_contents(__DIR__ . '/nested_exception-message.txt')
);
