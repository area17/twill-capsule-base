# Twill Capsules Base

### Description

A series of opinionated base classes and helpers for faster application bootstrapping using [Twill and Capsules](https://github.com/area17/twill).

The use of this repository is 100% optional, but some of our [Capsules](https://github.com/area17/twill-capsules) may be already using it to speed up things.

It's recommended to fork or just download this repository and put it on `app/Twill/Base`.

### Assumptions

This module assumes your application frontend routes are all prefixed by `front.`. This can be done easily by configuring them on your `RouteServiceProvider.php`:

```php
public function boot()
{
    $this->configureRateLimiting();

    $this->routes(function () {
        ...

        Route::middleware('web')
            ->namespace("{$this->namespace}\Front")
            ->name('front.')
            ->group(base_path('routes/front.php'));
    });
}
```
