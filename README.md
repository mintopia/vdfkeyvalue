# VDFKeyValue - Valve KeyValue Format Encoder

[![Total Downloads](https://img.shields.io/packagist/dt/mintopia/vdfkeyvalue.svg)](https://packagist.org/packages/mintopia/vdfkeyvalue)
[![Reference Status](https://www.versioneye.com/php/mintopia:vdfkeyvalue/reference_badge.svg)](https://www.versioneye.com/php/mintopia:vdfkeyvalue/references)

This library encodes native PHP data in to Valve Software's VDF KeyValue
format. This is used by the Source engine and many SourceMod mods.

## Installation

VDFKeyValue is available on [Packagist](https://packagist.org/packages/mintopia/vdfkeyvalue)
and installable via [Composer](https://getcomposer.org).

```bash
$ composer require mintopia/vdfkeyvalue
```

If you do not use composer, you can grab the code from GitHub and use any
PSR-4 compatible autoloader.

## Basic Usage

```php
<?php

use Mintopia\VDFKeyValue\Encoder;

// Create a new instance of the encoder and use it
$encoder = new Encoder;
$encoder->encode('foobar', $myObject);
```


You can encode objects, arrays, string, integers and anything else that can
be represented by a string.

The KeyValue format doesn't strictly support anything more than nested keys
and values, so any objects or numerical arrays ended up being treated as
associative arrays before encoding.

### Example

```php
<?php

use Mintopia\VDFKeyValue\Encoder;

$maps = new \stdClass;
$maps->payload = 'pl_goldrush';
$maps->cp = 'cp_badlands';

$data = new \stdClass;
$data->game = 'Team Fortress 2';
$data->appid = 440;
$data->bestmaps = $maps;
$data->characters = [
  'Demoman',
  'Scout',
  'Heavy Weapons Guy'
];

$encoder = new Encoder;
echo $encoder->encode('gameinfo', $data);
```

```bash
$ php example.php
"gameinfo"
{
        "game"  "Team Fortress 2"
        "appid" "440"
        "bestmaps"
        {
                "payload"       "pl_goldrush"
                "cp"    "cp_badlands"
        }
        "characters"
        {
                "0"     "Demoman"
                "1"     "Scout"
                "2"     "Heavy Weapons Guy"
        }
}
```

## About

### VDF KeyValue Format

The format is a simple nested tree structure, similar to JSON but without
arrays and requiring a root key.

 - [Valve Developer Wiki] (https://developer.valvesoftware.com/wiki/KeyValues)
 - [SourceMod Wiki] (https://wiki.alliedmods.net/KeyValues_%28SourceMod_Scripting%29)

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/mintopia/vdfkeyvalue/issues)

### Author

Jessica Smith - <jess@mintopia.net> - <http://mintopia.net>

### License

VDFKeyValue is licensed under the MIT License - see the `LICENSE` file for details
