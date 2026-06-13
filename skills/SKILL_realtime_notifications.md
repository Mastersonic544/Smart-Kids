## Installation & Config
Utilize the beyondcode/laravel-websockets package.
- Install: `composer require beyondcode/laravel-websockets` and `composer require pusher/pusher-php-server`
- Configure `.env`:
```dotenv
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=smartkids_app
PUSHER_APP_KEY=smartkids_key
PUSHER_APP_SECRET=smartkids_secret
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```
- In `config/websockets.php`, map to these env variables. Configure `config/broadcasting.php` to run Pusher on port 6001 locally.

## Creating a Custom Event Class
Create classes that implement `ShouldBroadcast`.

```php
namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PaymentReminderSent implements ShouldBroadcast
{
    public $message;
    public $user_id;

    public function __construct($message, $user_id)
    {
        $this->message = $message;
        $this->user_id = $user_id;
    }

    public function broadcastOn()
    {
        // Broadcast specifically to the user's private channel
        return new PrivateChannel('user.' . $this->user_id);
    }
}
```

## Frontend: Echo.js Listener in Blade Layout
Add the Laravel Echo script globally in `resources/views/layouts/app.blade.php`.

```html
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    import Echo from "laravel-echo"
    window.Pusher = require('pusher-js');

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'smartkids_key',
        wsHost: window.location.hostname,
        wsPort: 6001,
        forceTLS: false,
        disableStats: true
    });

    // Authenticated user ID injected via Blade
    let userId = {{ auth()->id() ?? 'null' }};
    
    if(userId) {
        window.Echo.private('user.' + userId)
            .listen('PaymentReminderSent', (e) => {
                // UI logic to display toaster/badge update
                console.log(e.message);
            });
    }
</script>
```

## Notification Types to Implement
- **Absence alert** → Broadcast to Parent
- **Payment overdue** → Broadcast to Parent + Admin (trigger 2 events or broadcast to a shared role channel)
- **New event announcement** → Broadcast to all Parents (can use Presence/Public channel `channel-parents`)
- **Message from educator** → Broadcast to Parent

## Database Notifications Fallback (Laravel Notify)
Simultaneously create Database records for offline persistence.

1. Ensure Database exists: `php artisan notifications:table`
2. Using Laravel's Notification Facade (e.g., `php artisan make:notification AbsenceNotification`):
```php
public function via($notifiable)
{
    // Important: 'database' persists it, 'broadcast' triggers the websocket.
    return ['database', 'broadcast']; 
}
```

## Marking as Read
Use Laravel's exact controller logic bound to the Blade UI action:

```php
// routes/web.php
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

// Controller logic
public function markAsRead($id)
{
    auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
    return response()->json(['success' => true]);
}
```
