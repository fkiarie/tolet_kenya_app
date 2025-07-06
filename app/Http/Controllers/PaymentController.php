<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments with filtering.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['tenant', 'unit'])->latest();

        if ($request->filled('month')) {
            $query->where('month_for', $request->input('month'));
        }

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->input('tenant_id'));
        }

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->input('unit_id'));
        }

        $payments = $query->paginate(20);
        $tenants = Tenant::all();
        $units = Unit::all();

        return view('payments.index', compact('payments', 'tenants', 'units'));
    }

    /**
     * Store a newly created payment from modal form.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'unit_id' => 'required|exists:units,id',
            'payment_date' => 'nullable|date',
            'month_for' => 'required|date_format:Y-m',
            'amount' => 'required|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0', 
            'method' => 'required|string',
            'reference' => 'nullable|string',
            'status' => 'nullable|in:paid,pending,failed',
            'notes' => 'nullable|string',
        ]);

        $amount = $request->amount;
        $rate = $request->commission_rate;
        $commissionAmount = round(($rate / 100) * $amount, 2);
        $landlordAmount = $amount - $commissionAmount;

        Payment::create([
            'tenant_id' => $request->tenant_id,
            'unit_id' => $request->unit_id,
            'payment_date' => $request->payment_date ?? now()->toDateString(),
            'month_for' => $request->month_for,
            'amount' => $amount,
            'commission_rate' => $rate,
            'commission_amount' => $commissionAmount,
            'landlord_amount' => $landlordAmount,
            'method' => $request->method,
            'reference' => $request->reference,
            'status' => $request->status ?? 'paid',
            'notes' => $request->notes,
        ]);


        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }
    /**
     * Export payments to PDF.
     */
    public function exportPdf(Request $request)
{
    $query = Payment::with(['tenant', 'unit'])->latest();

    if ($request->filled('month')) {
        $query->where('month_for', $request->month);
    }

    $payments = $query->get();

    $pdf = Pdf::loadView('payments.export', ['payments' => $payments]);

    return $pdf->download('payment-report.pdf');
}
}
// This controller handles payment management, including listing, filtering, and storing payments.
// It validates input data, calculates commission rates, and manages relationships with tenants and units.
// The `index` method retrieves payments with optional filtering by month, tenant, and unit.
// The `store` method processes the payment data from a modal form, ensuring all required fields are validated and correctly formatted.
// It calculates the commission rate and landlord amount before saving the payment to the database.
// The controller uses Laravel's built-in validation and Eloquent ORM for database interactions, making it efficient and easy to maintain.
// The `store` method redirects back to the payments index with a success message after successfully recording a payment.
// The controller is designed to be used in a Laravel application, leveraging the framework's features for routing, validation, and database management.
// It is part of a property management system, specifically handling tenant payments and their associated details.
// The controller is structured to be easily extendable for future features, such as payment updates or deletions.
// It uses dependency injection to access the request object, allowing for clean and testable code.
// The controller is ready to be integrated with views for displaying payment forms and lists, making it user-friendly for administrators managing tenant payments.
// The `Payment` model is used to interact with the `payments` table, which stores all payment-related data.
// The `Payment` model includes relationships to the `Tenant` and `Unit` models, allowing for easy access to related data.
// The controller is designed to follow best practices in Laravel development, ensuring maintainability and scalability.
// It can be tested using Laravel's built-in testing features, making it suitable for a production environment.
// The controller is part of a larger application that manages properties, tenants, and payments,
// providing a comprehensive solution for property management needs.