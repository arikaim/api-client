## Arikaim CMS Api Client
![version: 1.0.0](https://img.shields.io/github/release/arikaim/api-client.svg)
![license: MIT](https://img.shields.io/badge/License-MIT-blue.svg)


### Installation

```sh
composer require arikaim/api-client
```

### Usage

```php

require 'vendor/autoload.php';

use Arikaim\Client\ArikaimClient;

$apiKey = 'API KEY';
$endpoint = 'SITE URL';

$client = new ArikaimClient($apiKey,$endpoint);

```
