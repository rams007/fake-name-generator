# This project is just simple wrapper to obtain  data from  fakenamegenerator.com



## Installation

To add this package to your project, you can install it via composer by running

```bash
composer require rams007/fake-name-generator
```

Or you can just download all files and put it to your project folder.


## Usage

Here is a quick example how to use this package:

```php
use FakeNameGenerator\FakeNameGeneratorAPI;

$IdentityGenerator = new FakeNameGeneratorAPI();
$identity = $IdentityGenerator->getRandom();

```



