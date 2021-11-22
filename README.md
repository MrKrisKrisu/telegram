# Telegram

Veeeeery simple telegram function, so that I don't have to use these huge Telegram libraries in my projects and have the
function centrally.

## Installation

```
composer require mrkriskrisu/telegram
```

## Usage

### Send token on function call

```php
require_once './vendor/autoload.php';

\K118\Telegram::sendMessage(
    chatId: 123456789,
    text:   'Hello World!',
    disableNotification: true,
    token:  '...',
);
```

### Set token before usage

```php
require_once './vendor/autoload.php';

\K118\Telegram::setToken('...');
\K118\Telegram::sendMessage(
    chatId: 123456789,
    text:   'Hello World!',
);
```