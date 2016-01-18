# ArtisanExtended
###### A heap of commands for an extended artisan experience.

Disclaimer: this is my first package ever written,
so please bare with me if there are bugs or if there is a bad explanation of the commands.
Suggestions are always welcome!

This is a package that allows you to edit several configuration items with artisan.
It's at its beginning stage and it's fairly simple to use.

If you have any suggestions or you found a bug, please submit them here in the issue queue!

## Usage

### Installation
First execute the following command in the root of your Laravel project.
`composer require sebpro/artisanext:0.1.0`

When this command finished succesfully, add the following to your
providers-array in config/app.php:
`Sebpro\ArtisanExt\ArtisanExtServiceProvider::class,``

### List of commands
```
* app:url // You can change the URL for your app with this command
* app:env // You can change the environment for your app with this command
* app:serviceprovider // You can add a service provider to config/app.php with this command
* app:alias // You can add an alias to config/app.php with this command
* app:cipher // You can the cipher for your app with this command
* app:locale // You can change the locale for your app with this command
* app:cache // You can change the cache driver for your app with this command
* app:queue // You can change the queue driver for your app with this command
* app:session // You can change the session driver for your app with this command
* redis:host // You can change the host for redis in .env with this command
* redis:port // You can change the port for redis in .env with this command
* redis:password // You can change the password for redis in .env with this command
* db:host // You can change the DB Host in .env with this command
* db:name // You can change the DB Name in .env with this command
* db:password // You can change the DB Password in .env with this command
* db:user // You can change the DB User in .env with this command
```

### Explanation
Most commands are self-explanatory. Extended documentation will be written in a few days.

Two remarks:

The following two commands work only with their arguments in double quotes because of the nature of the arguments:
```
php artisan app:serviceprovider "Illuminate\Auth\AuthServiceProvider"
```

and

```
php artisan app:alias "'App'       => Illuminate\Support\Facades\App"
```

~ Sebastiaan (@Stekkz)
