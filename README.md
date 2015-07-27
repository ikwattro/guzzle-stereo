# Guzzle Stereo

**Record** and **Replay** HTTP Responses easily.

[![Build Status](https://travis-ci.org/ikwattro/guzzle-stereo.svg?branch=master)](https://travis-ci.org/ikwattro/guzzle-stereo)

### Requirements

* PHP 5.6+
* Guzzle 6

## Installation

Require the composer package :

```bash
composer require ikwattro/guzzle-stereo
```

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

require_once(__DIR__.'/vendor/autoload.php);

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

---

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
