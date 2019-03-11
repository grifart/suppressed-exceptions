# Suppressed exceptions for PHP

Suppressed exceptions are useful for aggregating more exceptions from unreliable resources.

Useful when you want to communicate that process failed, with a list of sibling exceptions that led to an error.

repositories:  
- [Grifart GitLab](https://gitlab.grifart.cz/grifart/suppressed-exceptions) [![pipeline status](https://gitlab.grifart.cz/grifart/suppressed-exceptions/badges/master/pipeline.svg)](https://gitlab.grifart.cz/grifart/suppressed-exceptions/commits/master)
- [GitHub](https://github.com/grifart/suppressed-exceptions) (mirror) [![Build Status](https://travis-ci.org/grifart/suppressed-exceptions.svg?branch=master)](https://travis-ci.org/grifart/suppressed-exceptions)

## Example usage

```php
$remoteSources = []; // classes representing unreliable remote sources

$exceptions = [];
foreach ($remoteSoures as $remoteSource) {
	try {
		$remoteSource->fetch(); // unsafe operation
	} catch (FetchingFailed $e) {
		$exceptions[] = $e;
		continue;
	}
}

if (count($exceptions) > 0) {
	$e = new ProcessingFailed();
	$e->addSuppressed(...$exceptions);
	throw $e;
}
```

You can also override exception constructor to provide better API

```php
final class EventPropagationFailedException extends \RuntimeException implements \Grifart\SuppressedExceptions\WithSuppressedExceptions
{
	use \Grifart\SuppressedExceptions\SuppressedExceptions;

	public function __construct(\Throwable ...$suppressed)
	{
		parent::__construct('Saving succeeded, but some listeners failed to complete their job. Please check suppressed exceptions for more information.');
		$this->addSuppressed(...$suppressed);
	}
}
```

Usage is then

```php
throw new EventPropagationFailedException(...$suppressedExceptions);
```


**TODO: screenshot from debugger** how it looks when catched



## More reading

- https://docs.oracle.com/javase/tutorial/essential/exceptions/tryResourceClose.html#suppressed-exceptions


