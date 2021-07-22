# Jack

A minimal set of static php classes-of-all-trades, also known as utils.

Jack are a work in progress. :wrench:  
Expect augments in following weeks/months of year 2021.

## Getting started

```bash
composer require ssitu/jacktrades
```

Or cherry pick files and methods to suit your needs.

## Init

```php
use SSITU\Jack;
require_once 'path/to/autoload.php';
Jack\Time::isoStamp();
Jack\Admin::phpInfo();
Jack\Token::sha40char();
# etc.
```

## Overview

### Admin

```php
Admin::benchmark(callable $callback, array $argm = array ());
Admin::bestHashCost(int|float $timeTarget = 0.05, int $cost = 8,  $algo = '2y');
Admin::serverInfos();
Admin::phpInfo();
Admin::hashAdminKey(string $adminKey);
```

### Time

```php
Time::isoStamp();
Time::stamp(string $format = 'Y-m-d H:i:s \\G\\M\\TO');
Time::subTime(string $date, string $interval, string $format = 'c');
Time::addTime(string $date, string $interval, string $format = 'c');
Time::isValidDate(string $date);
Time::dateObj(string $date);
Time::isExpired(string $givendate, string $maxdate);
Time::isInInterval(string $date, string|int $tolerance, string $unit = 'minutes');
Time::isInRange(string $date, string $minDate, string $maxDate = 'now');
Time::isFuture(string $date);
Time::convertEngToFormat(string $unit);
Time::countRemainingTime(string $startDate, string|int $count, string $unit = 'day');
Time::relativeInterval(object $originDate, object $targetDate, string $format);
Time::getInterval(string $origin, ?string $target = NULL, string $format = '%a');
Time::isValidTimezone(string $timezoneId);
Time::timezonesList();
```

### Token

```php
Token::timeBased();
Token::sha40char();
Token::getSecrets(string $token, array $eligiblechars);
Token::withSecret(string $secretchar, array $pool, int $tokenlength);
Token::b64basic(int $bytes = 64);
Token::hexBytes(int $bytes = 32);
```

Please note that these tokens all live in candy land.  
For crypto-secure tokens, you should look into [sodium](https://www.php.net/manual/en/book.sodium.php).

### Help

```php
Help::isValidHexColor(string $hexCode);
Help::resolveHexColor(string $hexCode);
Help::filterBool(mixed $var);
Help::filterValue(mixed $var,  $filter = 513);
Help::intLen(int $int);
Help::UpCamelCase(string $string);
Help::isHTML(string $string);
Help::isPostvInt(mixed $value);
Help::isValidPattern(string $pattern);
Help::boolify(mixed $value);
Help::num2alpha(int $n);
Help::alpha2num(string $a);
Help::intIsInRange(string|int $int, string|int $min, string|int $max);
```

### File

```php
File::recursiveMkdir(string $dir);
File::write(mixed $data, string $path, bool $formatRslt = false);
File::buffrInclude(string $path, mixed $v_ = NULL);
File::getContents(string $path);
File::readIni(string $path);
File::getExt(string $path);
File::reqTrailingSlash(string $dirPath);
File::readJson(string $path, bool $asArray = true, bool $strictMode = false);
File::saveJson(mixed $data, string $path, bool $formatRslt = false);
File::testReadWrite(array $paths);
File::moveFileObj(string $src, string $dest);
File::recursiveCopy(string $src, string $dest, array $excl = array ());
File::patternDelete(string $globPattern, mixed $flag = 0);
File::recursiveDelete(string $dirPath);
File::copySrcToDest(string $src, string $dest, bool $formatRslt = false);
File::recursiveGlob(string $base, string $pattern, mixed $flags = 0);
File::countInodes(string $path);
File::getDirSize(string $dir);
File::getOccupiedSpace(string $dir);
File::getAvailableSpace(string $dir, int $maxGB, bool $prct = true);
File::getRsltKeyword(mixed $boolish, string $success = 'success', string $error = 'err');
```

### Array

```php
Array::unsetNestedColumn(array $arr, mixed $columnKey);
Array::sortNestedByKey(array $arr, mixed $key);
Array::sortByKey(array $arr, mixed $key,  $order = 4);
Array::emptyItmsKeys(array $arr);
Array::filterEmptyItms(array $arr);
Array::filterNonEmptyItms(array $arr);
Array::allItmsAreEmpty(array $arr);
Array::noItmsAreEmpty(array $arr);
Array::countEmptyItms(array $arr);
Array::allItemsAreInt(array $arr);
Array::allItemsAreString(array $arr);
Array::merge(array $originValues, array $newValues);
Array::flatten(mixed $itm, array $out = array (), mixed $key = '');
Array::reIndex(array $arr, int $startAt = 0);
Array::longestItm(array $arr);
Array::longestKey(array $arr);
Array::strlenItms(array $arr);
Array::highestKey(array $arr);
Array::highestIntKey(array $arr);
}
```

### Web

```php
Web::redirect(string $url);
Web::addQueries(string $pageUrl, array $queries);
Web::getProtocol();
Web::isAlive(string $url);
Web::httpPost(string $url, array $data);
Web::b64url_encode(string $data);
Web::b64url_decode(string $data);
Web::extractSubDomain(?string $url = NULL, bool $exlude_www = true);
```

### Random

```php
Random::boolean();
Random::digit();
Random::speChar(array|string $speChars = '*&!@%^#$');
Random::multLetters(int $count, string $case = 'random');
Random::letter(string $case = 'random');
Random::mix(int $bytes = 32, array|string $speChars = '*&!@%^#$');
```

## Contributing

Sure! :raised_hands:
You can take a loot at [CONTRIBUTING](CONTRIBUTING.md).  
This repo also features a [Discussions](https://github.com/I-is-as-I-does/Jack/discussions) tab.

## License

This project is under the MIT License; cf. [LICENSE](LICENSE) for details.

![Jack of all Trades, c. Lynn-Fisher and Hyperbole and a half](Jack-of-all-Trades-Lynn-Fisher_Hyperbole-and-a-half.jpg)
