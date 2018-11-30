# Infobip Notifications Channel for Laravel 5.5+

This package makes it easy to send Sms notifications using [Infobip service](https://dev.infobip.com/) with Laravel 5.5 and above.

## Contents

- [Installation](#installation)
	- [Setting up your Infobip account](#setting-up-your-infobip-account)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Testing](#testing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

## Installation
You can install the package via composer:

``` bash
composer require princeton255/laravel-notifications-infobip
```

### Setting up your Infobip account
Add your Infobip Account Username, Password, and From Number to your `config/services.php`:

```php
// config/services.php
...
'infobip' => [
    'username' => env('INFOBIP_USERNAME'),
    'password' => env('INFOBIP_PASSWORD'),
    'from' => env('INFOBIP_FROM', 'IBTEST'),
],
...
```

## Usage
Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\Infobip\InfobipChannel;
use NotificationChannels\Infobip\InfobipMessage;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [InfobipChannel::class];
    }

    public function toInfobip($notifiable)
    {
        return (new InfobipMessage())
            ->content("Your {$notifiable->service} account was approved!");
    }
}
```

In order to let your Notification know which phone are you sending to, the channel will look for the `phone_number` attribute of the Notifiable model. If you want to override this behaviour, add the `routeNotificationForInfobip` method to your Notifiable model.

```php
public function routeNotificationForInfobip()
{
    return '+1234567890';
}
```

### Available Message methods

#### InfobipMessage

- `from('')`: Accepts a phone to use as the notification sender.
- `content('')`: Accepts a string value for the notification body.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Security

If you discover any security related issues, please email princeton.mosha@gmail.com instead of using the issue tracker.

## Credits
- Based on [Twilio SMS Notification channel](https://github.com/laravel-notification-channels/twilio) for Laravel
- This project uses the [Infobip Client library](https://github.com/infobip/infobip-api-php-client), and wraps it for smooth use in Laravel

## License
The MIT License (MIT).
