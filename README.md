# Suppressed exceptions for PHP

Suppressed exceptions are useful for aggregating more exceptions with unreliable resources.

You want to communicate that process failed, with following list of sibling exceptions that led to this error.

```php
$remoteSources = []; // classes representing unreliable remote sources

$exceptions = [];
foreach ($remoteSoures as $remoteSource) {
	try {
		$remoteSource->fetch(); // unrealiable
	} catch (FetchingFailed $e) {
		$exceptions[] = $e;
		continue;
	}
}

if (count($exceptions) > 0) {
	$e = new ProcessingFailed();
	$e->addSuppressed(...$exceptions);
	throw $e;
}

```