<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## File System Watcher

This solution leverages Laravel’s queue system, event/listener architecture, custom log channels, and a service-based approach for clean separation of concerns. 
It is built with extensibility and clarity in mind.



- Event-Driven Architecture: Follows Laravel's event/listener design pattern.
- Queueable Listeners: All heavy operations run in the background using Laravel’s queue worker.
- Custom Log Channel: A dedicated fswatcher log channel records watcher-related activity at storage/logs/fswatcher.log.
- Service-Oriented: All file-type-specific logic is encapsulated in dedicated service classes.
- Database Persistence: File state (path + last modified time) is stored persistently via a file_snapshots table.

## Installation

> composer install

#### Create a database and update .env db credentials
#### Update .env keys:

```dotenv
FSWATCHER_DIRECTORY="/app/watch"
FSWATCHER_JSON_FORWARDER_ENDPOINT="https://fswatcher.requestcatcher.com/"
FSWATCHER_BACON_API="https://baconipsum.com/api/?type=meat-and-filler"
FSWATCHER_MEME_API="https://meme-api.com/gimme"
```

> php artisan migrate

> php artisan schedule:work

> php artisan queue:work
