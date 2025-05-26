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
- Configurable Service Handlers: File-type-specific logic (e.g., JPG optimization, JSON forwarding) is mapped via config/fswatcher.php, making the system easy to extend without modifying core logic

The file_snapshots table is used to persist file state across scans because:
- Cache is volatile and may be cleared between deployments or restarts
- The database ensures reliable, long-term tracking of file changes
- It supports concurrent access and future extensibility (e.g., querying, auditing)

## Installation

#### Create a database and update .env db credentials
#### Update .env keys:

```dotenv
FSWATCHER_DIRECTORY="/app/watch"
FSWATCHER_JSON_FORWARDER_ENDPOINT="https://fswatcher.requestcatcher.com/"
FSWATCHER_BACON_API="https://baconipsum.com/api/?type=meat-and-filler"
FSWATCHER_MEME_API="https://meme-api.com/gimme"
```

> cp .env.example .env

> php artisan key:generate

> composer install

> php artisan migrate

> php artisan schedule:work

> php artisan queue:work



### Challenges Encountered
- Tracking file changes persistently across executions
- Avoiding unnecessary scans or reprocessing
- Cleanly handling multiple file types with different behaviors
- Keeping logic extensible without bloating a single class
- Ensuring safe and concurrent processing (especially for queued jobs)

### Approaches Considered
1. Caching vs. Database
   - Considered using Laravel's cache (e.g. Redis, file) to store file states.
   - Rejected because cache is volatile, can be cleared, and doesn’t support durable querying or long-term persistence.
   - Used a relational database table (file_snapshots) for reliable tracking of file presence and modification time.

2. Monolithic vs. Service-Oriented Design
   - Considered a single class with multiple match blocks for each file type.
   - Rejected due to complexity and difficulty in extending.
   - Used a service-oriented approach with dedicated classes for each file type, allowing clear separation of concerns and extensibility.

3. Inline logic vs. Service Classes 
   - Embedding logic for each file type inside the listener would make the class unmaintainable.
   - All listeners implement ShouldQueue to offload processing to Laravel's queue system.


## Solutions Implemented

- Persistent file tracking via the database
- Event-based design: creation, modification, and deletion emit dedicated events
- Queueable listeners for non-blocking and scalable background processing
- Dedicated log channel (fswatcher) for clear separation from general app logs
- Environment-configurable endpoints for JSON and Bacon Ipsum APIs
