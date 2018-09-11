# Impersonate a Laravel user

Authenticate as another user while maintaining previous authentication.

This works by using Laravels `Auth::onceUsingId()` feature where you can authenticate
as a user for that request only. A middleware will check if you're impersonating via a session variable
and activate `Auth::onceUsingId()` for every request until you stop impersonating.

## Installation

### 1. Composer

Execute the following command to get the latest version of the package:

```terminal
composer require bizhub/impersonate
```

### 2. Laravel

Add `CheckIfImpersonating` middleware to `app\Http\Kernel.php`

```php
  protected $middlewareGroups = [
      'web' => [
          // ...
          
          \Bizhub\Impersonate\Middleware\CheckIfImpersonating::class,
      ]
  ];
```
    
Add `CanImpersonate` trait to your `User` model

```php
namespace App;

use Bizhub\Impersonate\Traits\CanImpersonate;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use CanImpersonate;
    
    // ...
}
```

## Usage

```php
// Retrieve your user model
$user = User::find(1);

// Start impersonating
$user->impersonate();

// Redirect/reload the page

// ...

// Stop impersonating
Auth::user()->stopImpersonating();
```
