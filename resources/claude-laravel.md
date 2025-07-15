# Laravel 12.x Concise Reference for Code Generation

## File Storage

### Configuration
- Config file: `config/filesystems.php`
- Local driver: stores in `storage/app/private`
- Public disk: stores in `storage/app/public`

### Basic Operations
```php
use Illuminate\Support\Facades\Storage;

// Store files
Storage::put('file.txt', $contents);
Storage::disk('s3')->put('file.txt', $contents);

// Retrieve files
$contents = Storage::get('file.txt');
$data = Storage::json('data.json');

// Check existence
Storage::exists('file.txt');
Storage::missing('file.txt');

// File URLs
$url = Storage::url('file.txt');

// File uploads
$path = $request->file('avatar')->store('avatars');
$path = Storage::putFile('avatars', $request->file('avatar'));

// Delete files
Storage::delete('file.txt');
Storage::delete(['file1.txt', 'file2.txt']);
```

### Disk Configuration Examples
```php
// S3
'AWS_ACCESS_KEY_ID' => 'key',
'AWS_SECRET_ACCESS_KEY' => 'secret',
'AWS_DEFAULT_REGION' => 'us-east-1',
'AWS_BUCKET' => 'bucket-name'

// Public disk symlink
php artisan storage:link
```

## Context

### Usage
```php
use Illuminate\Support\Facades\Context;

// Add context data
Context::add('key', 'value');
Context::add(['key1' => 'value1', 'key2' => 'value2']);
Context::addIf('key', 'value'); // Only if key doesn't exist

// Retrieve context
$value = Context::get('key');
$subset = Context::only(['key1', 'key2']);
$subset = Context::except(['key1']);
$value = Context::pull('key'); // Get and remove
$all = Context::all();
```

## Artisan Console

### Commands
```bash
php artisan list                    # List all commands
php artisan help migrate           # Command help
php artisan tinker                 # REPL
php artisan make:command SendEmails # Generate command
```

### Custom Command Structure
```php
<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    protected $signature = 'mail:send {user} {--queue}';
    protected $description = 'Send marketing email';
    
    public function handle(): void
    {
        $userId = $this->argument('user');
        $queue = $this->option('queue');
        
        $this->info('Success message');
        $this->error('Error message');
        $this->line('Basic output');
    }
}
```

### Signature Syntax
```php
// Required argument
'command {user}'

// Optional argument
'command {user?}'

// Optional with default
'command {user=default}'

// Options (flags)
'command {user} {--queue}'
'command {user} {--queue=default}'
```

## Collections

### Creation and Basic Usage
```php
$collection = collect([1, 2, 3]);

// Chain operations
$result = collect(['taylor', 'abigail', null])
    ->map(fn($name) => strtoupper($name))
    ->reject(fn($name) => empty($name));
```

### Key Methods
```php
// Transform
$collection->map(fn($item) => $item * 2);
$collection->filter(fn($item) => $item > 5);
$collection->reject(fn($item) => $item < 5);

// Retrieve
$collection->all();                    // Get array
$collection->first();                  // First item
$collection->pluck('name');           // Extract values
$collection->contains('value');        // Check existence

// Aggregate
$collection->sum();                    // Sum values
$collection->avg();                    // Average
$collection->chunk(3);                // Split into chunks
$collection->collapse();              // Flatten arrays
```

## Helper Functions

### Array Helpers
```php
use Illuminate\Support\Arr;

Arr::add($array, 'key', 'value');     // Add if key missing
Arr::collapse($arrays);               // Flatten arrays
Arr::dot($array);                     // Flatten with dot notation
Arr::get($array, 'key.nested');      // Get nested value
Arr::has($array, 'key.nested');      // Check nested key exists
Arr::only($array, ['key1', 'key2']); // Extract specific keys
Arr::pluck($array, 'name');          // Extract column

// Global helpers
data_get($data, 'key.nested', 'default');
data_set($data, 'key.nested', 'value');
```

### Utility Helpers
```php
app();                                // Service container
app('SomeClass');                     // Resolve from container
collect($array);                      // Create collection
config('app.name');                   // Get config value
config(['app.debug' => true]);       // Set config runtime
dd($value);                          // Dump and die
env('APP_ENV', 'production');        // Environment variable
now();                               // Current Carbon instance
request();                           // Current request
request('key', 'default');          // Get input value
```

## HTTP Client

### Basic Requests
```php
use Illuminate\Support\Facades\Http;

// GET request
$response = Http::get('http://api.example.com/users');
$response = Http::get('http://api.example.com/users', ['page' => 1]);

// POST/PUT/PATCH with data
$response = Http::post('http://api.example.com/users', [
    'name' => 'John',
    'email' => 'john@example.com'
]);

// Form requests
$response = Http::asForm()->post('http://api.example.com/users', $data);
```

### Configuration
```php
// Headers
$response = Http::withHeaders([
    'Authorization' => 'Bearer token',
    'Accept' => 'application/json'
])->get('http://api.example.com');

// Shortcuts
$response = Http::withToken('token')->get('http://api.example.com');
$response = Http::acceptJson()->get('http://api.example.com');
$response = Http::withBasicAuth('user', 'pass')->get('http://api.example.com');

// Timeout and retries
$response = Http::timeout(30)->get('http://api.example.com');
$response = Http::retry(3, 100)->get('http://api.example.com');
```

### Response Handling
```php
// Response methods
$response->body();                    // Raw response
$response->json();                    // JSON decoded
$response->json('key.nested');       // Get nested JSON value
$response->status();                  // HTTP status code
$response->successful();              // 2xx status
$response->failed();                  // 4xx/5xx status
$response->clientError();             // 4xx status
$response->serverError();             // 5xx status

// Exception handling
$response->throw();                   // Throw on error
$response->throwIf($condition);      // Conditional throw
```

### Testing
```php
// Fake all requests
Http::fake();

// Fake specific URLs
Http::fake([
    'github.com/*' => Http::response(['data' => 'value'], 200),
    'google.com/*' => Http::response('Hello World', 200)
]);
```

## Queues

### Job Creation
```bash
php artisan make:job ProcessPodcast
```

### Job Structure
```php
<?php
namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessPodcast implements ShouldQueue
{
    use Queueable;
    
    public function __construct(
        public Podcast $podcast
    ) {}
    
    public function handle(AudioProcessor $processor): void
    {
        // Process the podcast
    }
}
```

### Dispatching Jobs
```php
// Basic dispatch
ProcessPodcast::dispatch($podcast);

// Conditional dispatch
ProcessPodcast::dispatchIf($condition, $podcast);
ProcessPodcast::dispatchUnless($condition, $podcast);

// Delayed dispatch
ProcessPodcast::dispatch($podcast)->delay(now()->addMinutes(10));
```

### Running Workers
```bash
php artisan queue:work                # Default connection
php artisan queue:work redis          # Specific connection
php artisan queue:work redis --queue=emails  # Specific queue
php artisan queue:work --tries=3      # Max attempts
```

### Job Batching
```php
use Illuminate\Support\Facades\Bus;

$batch = Bus::batch([
    new ProcessPodcast($podcast1),
    new ProcessPodcast($podcast2),
])->then(function (Batch $batch) {
    // All jobs completed
})->catch(function (Batch $batch, Throwable $e) {
    // First job failed
})->name('Process Podcasts')->dispatch();
```

### Failed Jobs
```bash
php artisan queue:failed              # List failed jobs
php artisan queue:retry {id}          # Retry specific job
php artisan queue:retry all           # Retry all failed jobs
```

## String Utilities

### Static Methods
```php
use Illuminate\Support\Str;

// Case conversion
Str::camel('foo_bar');               // fooBar
Str::snake('fooBar');                // foo_bar
Str::kebab('fooBar');                // foo-bar
Str::studly('foo_bar');              // FooBar
Str::title('hello world');           // Hello World
Str::upper('hello');                 // HELLO
Str::lower('HELLO');                 // hello

// String manipulation
Str::after('Hello World', 'Hello '); // World
Str::before('Hello World', ' World'); // Hello
Str::contains('Hello World', 'World'); // true
Str::startsWith('Hello', 'He');      // true
Str::endsWith('World', 'ld');        // true
Str::replace('foo', 'bar', 'foo baz'); // bar baz
Str::limit('Long text...', 10);      // Long text...
Str::length('hello');                // 5

// Utilities
Str::random(32);                     // Random string
Str::uuid();                         // Generate UUID
Str::plural('car');                  // cars
Str::singular('cars');               // car
```

### Fluent Strings
```php
use Illuminate\Support\Str;

$result = Str::of('Hello World')
    ->lower()
    ->replace(' ', '_')
    ->append('_suffix')
    ->toString();  // hello_world_suffix

// Fluent methods mirror static methods
Str::of('foo_bar')->camel();         // fooBar
Str::of('text')->contains('tex');    // true
Str::of('path/file.txt')->basename(); // file.txt
```

## Quick Reference Patterns

### File Upload Handling
```php
public function store(Request $request)
{
    $path = $request->file('document')->store('documents', 'public');
    $url = Storage::url($path);
    
    // Save $path to database
    Document::create(['path' => $path, 'url' => $url]);
}
```

### API Response Pattern
```php
public function fetchData()
{
    $response = Http::withToken(config('api.token'))
        ->timeout(10)
        ->get('https://api.example.com/data');
    
    if ($response->successful()) {
        return $response->json();
    }
    
    throw new Exception('API request failed');
}
```

### Background Job Pattern
```php
// Controller
public function process(Request $request)
{
    ProcessData::dispatch($request->validated())
        ->delay(now()->addSeconds(30));
    
    return response()->json(['message' => 'Processing started']);
}

// Job
public function handle()
{
    Context::add('job_id', $this->job->getJobId());
    // Process data with context logging
}
```