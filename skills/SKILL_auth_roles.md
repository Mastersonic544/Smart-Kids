## Package Setup
Use the `spatie/laravel-permission` package for roles and permissions.

## Roles & Guards
- **Roles:** `admin`, `educateur`, `parent`
- **Guards:** `web` (Blade sessions)

## Route Protection Pattern
Use middleware groups to protect your routes by role:

```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});

Route::middleware(['auth', 'role:educateur'])->group(function () {
    Route::get('/educateur/classes', [EducatorClassesController::class, 'index']);
});

Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent/children', [ParentChildrenController::class, 'index']);
});
```

## How to Assign Role on User Creation
Use the `assignRole` method from the Spatie package:

```php
$user = User::create([
    'name' => 'Jane Parent',
    'email' => 'jane@example.com',
    'password' => Hash::make('password123'),
]);

$user->assignRole('parent'); // Assigns the 'parent' role
```

## How to Seed the 3 Roles in DatabaseSeeder
Ensure roles exist before creating users:

```php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create the roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'educateur', 'guard_name' => 'web']);
        Role::create(['name' => 'parent', 'guard_name' => 'web']);

        // Seed a sample admin
        $admin = User::create(['name' => 'Admin User', 'email' => 'admin@admin.com', 'password' => bcrypt('password')]);
        $admin->assignRole('admin');
    }
}
```

## Policy Example: ChildPolicy
Policies control individual record access. Admin can do all, educateur sees own class, parent sees own child.

```php
namespace App\Policies;

use App\Models\User;
use App\Models\Child;

class ChildPolicy
{
    public function view(User $user, Child $child)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('educateur')) {
            // Assume the user has a relationship to classes, and the child to a class
            return $user->classes()->where('id', $child->class_id)->exists();
        }

        if ($user->hasRole('parent')) {
            return $user->id === $child->parent_id;
        }

        return false;
    }
    
    // Abstract other checks similarly
}
```
