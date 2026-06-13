<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ErpService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ErpController extends Controller
{
    public function __construct(private readonly ErpService $erpService) {}

    public function index(): View
    {
        $tenantAdminId = Auth::id();
        $data = $this->buildPayload($tenantAdminId);

        return view('admin.erp.index', $data);
    }

    public function exportPdf(): Response
    {
        $tenantAdminId = Auth::id();
        $data = $this->buildPayload($tenantAdminId);
        $data['print'] = true;

        $pdf = Pdf::loadView('admin.erp.export', $data)->setPaper('a4');

        return $pdf->download('smartkids-erp-'.now()->format('Y-m-d').'.pdf');
    }

    private function buildPayload(int $tenantAdminId): array
    {
        return [
            'ledger' => $this->erpService->tuitionLedger($tenantAdminId),
            'revenueByClassroom' => $this->erpService->revenueByClassroom($tenantAdminId),
            'monthlyRevenue' => $this->erpService->monthlyRevenueSeries($tenantAdminId),
            'employeeOfMonth' => $this->erpService->employeeOfTheMonth($tenantAdminId),
            'generatedAt' => now(),
        ];
    }
}
