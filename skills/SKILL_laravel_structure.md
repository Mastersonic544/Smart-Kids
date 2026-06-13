- Controllers in app/Http/Controllers/{Module}/
- Services in app/Services/{Module}Service.php
- Repositories: app/Repositories/{Module}RepositoryInterface.php and app/Repositories/{Module}Repository.php
- Form Requests in app/Http/Requests/{Module}/
- Models in app/Models/
- Policies in app/Policies/
- Resources/Transformers in app/Http/Resources/
- Blade views in resources/views/{module}/
- Routes split: routes/web.php (Blade) + routes/api.php (API)

## Naming Conventions
- Classes are StudlyCase.
- Methods and variables are camelCase.
- Model names are singular (e.g., `Child`); table names are plural (`children`).
- Services suffix: `Service` (e.g., `ChildService`).
- Repositories suffix: `Repository` (e.g., `ChildRepository`).

## How to Bind a Repository to an Interface
In your `AppServiceProvider` (or a dedicated `RepositoryServiceProvider`):

```php
use App\Repositories\ChildRepositoryInterface;
use App\Repositories\ChildRepository;

public function register()
{
    $this->app->bind(ChildRepositoryInterface::class, ChildRepository::class);
}
```

## How to Register a Service Provider
Add your new provider into the `providers` array config (`config/app.php` or `bootstrap/providers.php` in Laravel 11).

## Worked Example: "Children" Module
- **Controller:** `app/Http/Controllers/Children/ChildController.php`
- **Service:** `app/Services/ChildService.php`
- **Repository Auth Interface:** `app/Repositories/ChildRepositoryInterface.php`
- **Repository Direct:** `app/Repositories/ChildRepository.php`
- **Form Request:** `app/Http/Requests/Children/StoreChildRequest.php`
- **Model:** `app/Models/Child.php`
- **Policy:** `app/Policies/ChildPolicy.php`
- **Resource/Transformer:** `app/Http/Resources/ChildResource.php`
- **Blade views:** 
  - `resources/views/children/index.blade.php`
  - `resources/views/children/create.blade.php`
  - `resources/views/children/show.blade.php`
  - `resources/views/children/edit.blade.php`
