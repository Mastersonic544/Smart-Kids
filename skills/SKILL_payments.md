## Payment Model Fields
- `id` (PK)
- `child_id` (Foreign Key to children table)
- `amount` (Decimal)
- `due_date` (Date)
- `paid_at` (Datetime, nullable)
- `status` (Enum/String: 'pending', 'paid', 'overdue')
- `receipt_path` (String, nullable)

## PaymentService Methods

```php
namespace App\Services;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PaymentService
{
    public function createInvoice(array $data)
    {
        return Payment::create([
            'child_id' => $data['child_id'],
            'amount' => $data['amount'],
            'due_date' => $data['due_date'],
            'status' => 'pending',
        ]);
    }

    public function markAsPaid(Payment $payment)
    {
        $payment->update([
            'status' => 'paid',
            'paid_at' => Carbon::now(),
        ]);
        
        $this->generateReceipt($payment);
        
        return $payment;
    }

    public function generateReceipt(Payment $payment)
    {
        // Needs barryvdh/laravel-dompdf
        $pdf = Pdf::loadView('payments.receipt_pdf', compact('payment'));
        
        $fileName = 'receipts/receipt_' . $payment->id . '_' . time() . '.pdf';
        
        // Save PDF to storage/app/receipts/
        Storage::disk('local')->put($fileName, $pdf->output());
        
        $payment->update(['receipt_path' => $fileName]);
    }

    public function sendReminder(Payment $payment)
    {
        // Example: Push notification or email logic triggers here
        // Notification::send($payment->parent, new PaymentReminderNotification($payment));
    }
}
```

## PDF Receipt Generation (DomPDF)
- Generate a blade template to map to PDF logic inside `resources/views/payments/receipt_pdf.blade.php`.
- Serve the PDF download through the Controller:

```php
public function downloadReceipt(Payment $payment)
{
    $this->authorize('view', $payment);

    if (!$payment->receipt_path || !Storage::exists($payment->receipt_path)) {
        abort(404, 'Receipt not found');
    }

    return Storage::download($payment->receipt_path);
}
```

## Scheduled Command for Auto-Reminders
Create a job/command (e.g. `php artisan make:command CheckOverduePayments`) and configure Laravel Scheduler via `app/Console/Kernel.php` (or `routes/console.php`).

```php
// Inside command handle method
public function handle(PaymentService $paymentService)
{
    $overduePayments = Payment::where('status', 'pending')
        ->whereDate('due_date', '<', now())
        ->get();

    foreach ($overduePayments as $payment) {
        $payment->update(['status' => 'overdue']);
        $paymentService->sendReminder($payment);
    }
}

// Inside scheduler (daily check)
$schedule->command('payments:check-overdue')->daily();
```
