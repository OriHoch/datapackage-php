# Data Package

[![Travis](https://travis-ci.org/frictionlessdata/datapackage-php.svg?branch=master)](https://travis-ci.org/frictionlessdata/datapackage-php)
[![Coveralls](http://img.shields.io/coveralls/frictionlessdata/datapackage-php.svg?branch=master)](https://coveralls.io/r/frictionlessdata/datapackage-php?branch=master)
[![Packagist](https://img.shields.io/packagist/dm/frictionlessdata/datapackage.svg)](https://packagist.org/packages/frictionlessdata/datapackage)
[![SemVer](https://img.shields.io/badge/versions-SemVer-brightgreen.svg)](http://semver.org/)
[![Gitter](https://img.shields.io/gitter/room/frictionlessdata/chat.svg)](https://gitter.im/frictionlessdata/chat)

A utility library for working with [Data Package](https://specs.frictionlessdata.io/data-package/) in PHP.


## Getting Started

### Installation

```bash
$ composer require frictionlessdata/datapackage
```

### Usage

```php
use frictionlessdata\datapackage;

$datapackage = new Datapackage("tests/fixtures/multi_data_datapackage.json");
foreach ($datapackage as $resource) {
    print("-- ".$resource->name()." --");
    $i = 0;
    foreach ($resource as $dataStream) {
        print("-dataStream ".++$i);
        foreach ($dataStream as $line) {
            print($line);
        }
    }
}
```


## Contributing

Please read the contribution guidelines: [How to Contribute](CONTRIBUTING.md)
