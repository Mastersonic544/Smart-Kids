## 3 PDF Types

1. **Enrollment dossier PDF**
   - **Template:** `resources/views/pdf/enrollment.blade.php`
   - **Content:** child info + parent info + class + documents checklist.
2. **Payment receipt PDF**
   - **Template:** `resources/views/pdf/receipt.blade.php`
   - **Content:** child name, amount, date, status, QR-style reference number.
3. **Monthly activity report PDF**
   - **Template:** `resources/views/pdf/activity_report.blade.php`
   - **Content:** child name, activities attended, educator notes.

## DomPDF Call Pattern & Service Integration
Inside the relevant Service class (e.g. `EnrollmentService` or `PaymentService`):

```php
use Barryvdh\DomPDF\Facade\Pdf;

// Generating the view instance
$pdf = Pdf::loadView('pdf.receipt', compact('payment'));

// DomPDF configuration for compatibility and sizing
$pdf->setPaper('A4', 'portrait');
```

## File Storage & Paths
Standardize storage location pattern: `storage/app/public/documents/{child_id}/{type}_{date}.pdf`

```php
use Illuminate\Support\Facades\Storage;

// Set filename based on conventions
$filename = 'documents/' . $child->id . '/receipt_' . now()->format('Y_m_d_H_i_s') . '.pdf';

// Store permanently so it can be streamed inside authenticated routes later
Storage::disk('public')->put($filename, $pdf->output());
```

## Download vs. Save to Disk
- **Saving directly (Background Jobs / Services):**
  ```php
  Storage::disk('public')->put($path, $pdf->output());
  ```
- **Return as inline browser view (Stream):**
  ```php
  return $pdf->stream('ActivityReport.pdf');
  ```
- **Return as direct forced browser download:**
  ```php
  return $pdf->download('ActivityReport.pdf');
  ```

## Styling, Layout & CSS Limitations
- **No Flexbox or CSS Grid:** DomPDF engine operates on HTML4/CSS2 rendering limits.
- **Tables are mandatory:** Use traditional `<table>` layouts.
- **Embedded / Inline styling:** Avoid external stylesheets that rely on complex Tailwind rules. Write `<style>` tags directly inside your Blade PDF files.
