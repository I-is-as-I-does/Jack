# Jacks

A minimal set of static php classes-of-all-trades, also known as utils.

An error handler can be plugged-in the `File` class.  
You can use [Houston](https://github.com/I-is-as-I-does/Houston)!

Jacks are a work in progress. :wrench:  
Expect augments in following weeks/months of year 2021.

## Getting started

````bash
$ composer require exoproject/jacks
````

Or cherry pick files and methods to suit your needs.

## Overview
````php
require_once(dirname(__DIR__).'\\vendor\\autoload.php');
````

### Time
````php
use ExoProject\Jacks\Time;

Time::stamp($format = "Y-m-d H:i:s \G\M\TO");
Time::addTime($date, $interval, $format = "Y-m-d H:i:s \G\M\TO");
Time::isExpired($givendate, $maxdate);
Time::getInterval($origin, $target, $format = '%a');
Time::isValidTimezone($timezoneId);
````

`getInterval` default `$format` is days.  
You can take a look at the [php doc](https://www.php.net/manual/en/datetime.createfromformat.php) for format alternatives.

### Token
````php
use ExoProject\Jacks\Token;

Token::timeBased();
Token::sha40char();
Token::getSecrets($token, $eligiblechars);
Token::withSecret($secretchar, $pool, $tokenlength);
Token::b64basic($bytesnbr = 64);
````

Please note that these tokens all live in candy land.  
For crypto-secure tokens, you should look into [sodium](https://www.php.net/manual/en/book.sodium.php).

### Trinkets
````php
use ExoProject\Jacks\Trinkets;

Trinkets::sendEmail($subject, $content, $sender, $recipient, $sitename);
Trinkets::isAlive($theURL);
Trinkets::isPostvInt($value);
Trinkets::boolify($val);
````

`sendEmail` is nice if you don't need a fully-fledge email handler. Using a modest custom method can actually avoid some injections, so that your website/app doesn't turn into a spam distributor.  
Plus it's convenient to mutualise headers and encoding.

`isPostvInt` works even if `$value` is a string-integer.

### File
````php
use ExoProject\Jacks\File;

File::write($target, $content);
File::buffrInclude($path);
File::requireContents($path);
File::checkPath($path);
File::getinival($path, $key);
File::handleb64img($dataimg, $dest = false);
File::ext($file);
File::readJson($path);
File::saveJson($data, $path);
File::testReadWrite($filesOrfolders);
````

Note that `handleb64img` requires [GD](https://www.php.net/manual/en/book.image.php) if you wish to ouput bin image instead of saving it as a png file.

I recommend to use File alongside an error handler.  
There's a property and a dedicated method to plug one in.

````php
protected  $errorHdlr_class = false;
protected  function  callErrHandlr($errMsg);
````
To use ExoProject [Houston](https://github.com/I-is-as-I-does/Houston) error handler:
````bash
$ composer require exoproject/houston
````
````php
$errorHdlr_class = 'ExoProject\Houston\Houston';
````
Or set up your own!

## Contributing

Sure! :raised_hands:
You can take a loot at [CONTRIBUTING](CONTRIBUTING.md).  
This repo also features a [Discussions](https://github.com/I-is-as-I-does/Jacks/discussions) tab.

## License

This project is under the MIT License; cf. [LICENSE](LICENSE) for details.
