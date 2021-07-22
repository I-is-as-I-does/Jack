# Jack

A minimal set of static php classes-of-all-trades, also known as utils.

Jack are a work in progress. :wrench:  
Expect augments in following weeks/months of year 2021.

## Getting started

```bash
$ composer require ssitu/jacktrades
```

Or cherry pick files and methods to suit your needs.

## Overview

Main Jack class is a singleton, handling Trades.

```php
require_once('path/to/composer/autoload.php');
use SSITU\Jack\Jack;
```

### Admin

```php
Jack::Admin()->isAlive($url);
Jack::Admin()->getSubDomain($noWWW = true);
Jack::Admin()->serverInfos();
Jack::Admin()->phpInfo();
Jack::Admin()->getDirSize($dir);
Jack::Admin()->getAvailableSpace($dir, $maxGB);
```

### Time

```php
Jack::Time()->stamp($format = "Y-m-d H:i:s \G\M\TO");
Jack::Time()->addTime($date, $interval, $format = "Y-m-d H:i:s \G\M\TO");
Jack::Time()->isExpired($givendate, $maxdate);
Jack::Time()->getInterval($origin, $target, $format = '%a');
Jack::Time()->isValidTimezone($timezoneId);
```

`getInterval` default `$format` is days.  
You can take a look at the [php doc](https://www.php.net/manual/en/datetime.createfromformat.php) for format alternatives.

### Token

```php
Jack::Token()->timeBased();
Jack::Token()->sha40char();
Jack::Token()->getSecrets($token, $eligiblechars);
Jack::Token()->withSecret($secretchar, $pool, $tokenlength);
Jack::Token()->b64basic($bytesnbr = 64);
```

Please note that these tokens all live in candy land.  
For crypto-secure tokens, you should look into [sodium](https://www.php.net/manual/en/book.sodium.php).

### Help

```php
Jack::Help()->num2alpha($n);
Jack::Help()->alpha2num($a);
Jack::Help()->isPostvInt($value);
Jack::Help()->boolify($value);
Jack::Help()->updateArray($basevalues, $updatevalues);
Jack::Help()->reIndexArray($arr, $startAt = 0);
Jack::Help()->arrayLongestItem($arr);
Jack::Help()->arrayLongestKey($arr);
Jack::Help()->arrayItemsStrlen($arr);
```

`isPostvInt` works even if `$value` is a string-integer.

### File

```php
Jack::File()->write($data, $path);
Jack::File()->buffrInclude($path);
Jack::File()->getContents($path);
Jack::File()->readIni($path);
Jack::File()->handleb64img($dataimg, $path = false);
Jack::File()->getExt($path);
Jack::File()->readJson($path);
Jack::File()->saveJson($data, $path);
Jack::File()->testReadWrite($paths);
```

Note that `handleb64img` requires [GD](https://www.php.net/manual/en/book.image.php) if you wish to ouput bin image instead of saving it as a png file.

## Contributing

Sure! :raised_hands:
You can take a loot at [CONTRIBUTING](CONTRIBUTING.md).  
This repo also features a [Discussions](https://github.com/I-is-as-I-does/Jack/discussions) tab.

## License

This project is under the MIT License; cf. [LICENSE](LICENSE) for details.
