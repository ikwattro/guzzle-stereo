# Guzzle Stereo

**Record** and **Replay** HTTP Responses easily.

[![Build Status](https://travis-ci.org/ikwattro/guzzle-stereo.svg?branch=master)](https://travis-ci.org/ikwattro/guzzle-stereo) [![CodeHunt.io](https://img.shields.io/badge/vote-codehunt.io-02AFD1.svg)](http://codehunt.io/sub/guzzle-stereo/?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

### Requirements

* PHP 5.6+
* Guzzle 6

## Installation

Require the composer package :

```bash
composer require ikwattro/guzzle-stereo
```

NB: If you're using the Symfony Framework, you can take a look at the [GuzzleStereoBundle](https://github.com/estahn/guzzle-stereo-bundle) from @estahn.

## Basics

### Recorder

A recorder is the main object that knows everything about tapes and how to store them afterwards.

### Tapes

A tape will record `Response` objects. It has a name and can have `filters`. A filter can tell for example that only 
Responses with a 200 status code will be recorded in that tape.

Defining tapes and filters is done through a `yaml` file definition :

```yaml
tapes:
	my_tape:
		filters:
			status_code: 200
```

This tape will record only success responses.

### Filters

A filter is a `rule` telling if the `Response` object should be included or not. There is a set of built-in filters available
with the library or you can create your own and register them.

NB: If you feel that your filter can be generic enough, do not hesitate to open a PullRequest

### Store directory

In order to be replayed later (see the Replay section below), all tapes will then be dumped in json files to disk. You need
to provide a writable directory.

### Player

A player is able to replay dumped json files as `Response` objects. A nice use case is to replay them with a `Mock Handler` in
your test suites.

## Usage

### Recording

Instantiate the recorder by providing a writable store directory and the location of your tapes definitions file :

```php
require_once(__DIR__.'/vendor/autoload.php');

use Ikwattro\GuzzleStereo\Recorder;

$recorder = new Recorder(__DIR__.'/var/records', __DIR__.'/stereo.yml');
```

Next, when creating your Guzzle client, you need to make him aware of the recorder. An easy way to do this is by using a Middleware
available with the library :

```php
$stack = \GuzzleHttp\HandlerStack::create();
$stack->push(\Ikwattro\GuzzleStereo\RecorderMiddleware::record($recorder));

$client = new \GuzzleHttp\Client(['handler' => $stack]);
```

You can now make http requests with the Client as you would usually do, for e.g. here we'll call the Github events API 10 times :

```php
for ($i = 0; $i < 10; $i++) {
	try {
		$client->get('https://api.github.com/events');
	} catch (RequestException $e) {
		// Do what you want
	}
}
```

Finally, you'll need to tell the recorder to dump the tapes to the disk :

```php
$recorder->dump();
```

A file named `record_ + {tape_name}` will be created in the provided store directory containing the responses passing the filters :

### Replaying

In order to replay the recorded tapes, you can use the `Player`. The player is in fact creating a Mock Handler and will return you
a `GuzzleHttp\Client` instance created with the MockHandler containing the responses from the tape file.

```php
use Ikwattro\GuzzleStereo\Player;

$player = Player::replayFromTape('/path/to/tape.json');

$player->get('/');
// will return you the first response record present in the tape
```

---

## Filters reference

### StatusCode

Include the `Response` only if it has the corresponding status code.

```yaml
tapes:
	my_tape:
		filters:
			status_code: 200
```

### Non Empty Body

Include the `Response` only if the body is not empty.

```yaml
tapes:
	my_tape:
		filters:
			non_empty_body: ~
```

### Has Header

Include the `Response` only if she contains a header with the specified key.

```yaml
tapes:
	my_tape:
		filters:
			has_header: "Content-Type"
```

## Creating your own filters

Creating a filter is really easy. You need to create a filter class implementing `Ikwattro\GuzzleStereo\Filter\FilterInterface` and
declaring the two methods :

* `public static function getName()`
* `public function isIncluded(ResponseInterface $response)`

The `getName` static function is responsible for defining the name of the filters in your tapes.

The `isIncluded` function will contain the logic determining if the received `Response` should be included or not in the Tape.

The following example filter will receive a response from the Github events api, and will record it only if the body contains
an event done by the Github users you will pass as arguments when associating your filter to a tape.

```php
<?php
namespace Acme\MyApp\Filter;

use Ikwattro\GuzzleStereo\Filter\FilterInterface;
use Psr\Http\Message\ResponseInterface;

class ActorFilter implements FilterInterface
{
	const FILTER_NAME = "actor_filter";
	
	protected $users;
	
	public function__construct(array $users = array())
	{
		$this->users = $users;
	}
	
	public static function getName()
	{
		return self::FILTER_NAME;
	}
	
	public function isIncluded(ResponseInterface $response)
	{
		$body = json_decode((string) $response->getBody());
		foreach ($body as $event) {
			$actor = $event['actor']['login'];
			if (in_array($actor, $this->users)) {
				return true;
			}
		}
		
		return false;
	}
}
```

You can now add your custom filter in your configuration and use it in your tapes :

```yaml
custom_filters:
	- "Acme\MyApp\Filter\ActorFilter"
	- 
tapes:
	my_tape:
		filters:
			actor_filter: ["jexp","ikwattro","luanne"]
```

Your tape will now contain only Responses that included in their actors one of the provided actors.

#### Extra configuration setting :

Your Responses objects can contain a specific header as a marker by setting the following configuration flag :

```yaml
marker_header: true
```

which will add a `X-Guzzle-Stereo` header with a `true` value.

### TODO

* more filters
* blacklists
* null tape
* better configuration management (maybe Symfony config component)
* combined requestAndResponses
* filter what should be returned from the player
* your ideas ?

---

### Tests

`phpspec` and `phpunit` are used for the tests:

```bash
./vendor/bin/phpspec run -f pretty
./vendor/bin/phpunit
```

### License

The library is issued under the MIT license, please refer to the LICENSE file provided with the package.

### Contribute

Feel free to contribute or report issues on Github.

### Author

Christophe Willemsen

Twitter: [@ikwattro](https://twitter.com/ikwattro)

Github: [@ikwattro](https://github.com/ikwattro)
