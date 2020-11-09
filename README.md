# Mail Sender
a PHP service for sending email using REST API

## Supported email providers
- [Sendgrid](https://sendgrid.com/)
- [Mailjet](https://www.mailjet.com/)

## Functionality

### Multi Sender support

To be able to send Multiple emails, I created namespace Mailers. For each of the supported external providers there is subfolder.

Each of the providers had multiple content types classes that extends the abstract class **Message**. This class declares 2 methods:

-  for extracting the content type:
```php 
  abstract public function getMessageType(): string;
``` 
- for ex getting the message content
```php 
  public function getMessage(): string {}
``` 

To be able to add message formats that are not natively supported in the providers, I added abstract class **Parser** that is going to be used as base for feature parser classes. For now there is only MarkdownParser that changes the body of markdown content type to html.

For both Mailjet and Sendgrid there are strategies that implemented interface **EmailContent**. 
It declares methods:
```php
     public function getTypeAsText(): string;  
```
```php
    public function getMessageText(): string;
```
In the interface I added the constants for the message types that are supported my this service:

```php
    const MAIL_FORMAT_TEXT = "text";
    const MAIL_FORMAT_HTML = "html";
    const MAIL_FORMAT_MARKDOWN = "markdown";
```
 
I created 2 adapters for working with the externals APIs, by creating 2 classes that implements the **SendEmail** interface.
This interface declares only one method: 
```php
    public function sendEmail(array $from, array $recipients, string $subject, string $contentType, string $message): bool{};
```

Both off this apter classes are returned by **MailServiceFactory** that creates service object by provided service const.
The factory has one additional method:

```php
       public static function getEnabledSenders(){
            //changing constants order will determine service priority
            return [
                self::MAIL_JET_MAIL_SERVICE,
                self::SEND_GRID_MAIL_SERVICE
            ];
        }
````
**getEnabledSenders** gives information to the business logic about how many fallback email senders we have.

### Queue logic

The email queue is implemented by using the default Laravel queue functionality, by creating the job **SendEmailJob**.
This Job is dispatched in the **EmailMessageService** when new email is created:

```php
    public function makeItem(array $inputs): ?Model
    {
        $emailMessage = parent::makeItem($this->reformatInputs($inputs));
        EmailCreate::dispatch($emailMessage);
        SendEmailJob::dispatch($emailMessage);
        return $emailMessage;
    }
````
The system automatically logs the states of the email message by adding events and log listeners
```php
    //...
    'App\Events\EmailCreate' => [
        'App\Listeners\LogCreate'
    ],
    'App\Events\EmailProcessing' => [
        'App\Listeners\LogProcessing',
    ],
    'App\Events\EmailFailed' => [
        'App\Listeners\LogFailure',
    ],
    'App\Events\EmailSend' => [
        'App\Listeners\LogSuccess',
    ]
    //...
```

### Sender failure fallback

Fallback logic is automated by using the method **getEnabledSenders()** and the attempts counter of the job

```php
 public function getFallBackService(int $attempts): int
    {
        $mailers = $this->getSupportedMailers();

        return $mailers[($attempts > 1) ? $attempts % sizeof($mailers) : 0];
    }
```

The algorithm is simple: After the first attempt get index of the sender service by calculating: 
````
    {INDEX_OF_FAILLBACK_SERVICE} = {CURRENT_ATTEMPT} % {NUMBER_FOR_SUPPORTED_SERVICES}
````


### Adding business logic

For main business logic I used Repository and Service patterns, that can be used with binding of their interfaces in the classes that needs them

### Adding Artisan Command and API resource controller

To create email message execute command

```shell script
    php artisan email:send  <address> <subject> <message> [<type>]
````
email:send can be used to send email message only to one recipient. In case of wrong type, user will be prompt to select from an array of correct ones;

**EmailMessageController** provides the user with api functionality

## Feature functionalities
- Push notification to users;
- Service policy to control API usage;
- More email providers;
- Adding queue priority;

## Installation

1. Add api keys to .env fail;
2. To use SendGrid add your API key to **SENDGRID_API_KEY** in your *.env*;
3. To use MailJet you need to set 2 apy keys **MJ_APIKEY_PUBLIC** and **MJ_APIKEY_PRIVATE** in your *.env* fail;
4. Go to laradock folder and create Laradock containers:

````shell script
  docker-compose -f production-docker-compose.yml up -d
````
5. To enter the docker workplace container
```shell script
  docker-compose exec workspace bash
```   
6. To test the service database needs to be seeded:

````shell script
    php artisan migrate;
    php artisan db:seed;
````

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
