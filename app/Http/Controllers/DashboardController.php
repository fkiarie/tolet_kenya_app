<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $landlords = Landlord::count();
        $buildings = Building::count();
        $units = Unit::count();
        $unitsVacant = Unit::where('status', 'vacant')->count();
        $unitsOccupied = Unit::where('status', 'occupied')->count();
        $tenants = Tenant::count();
        $latestTenants = Tenant::latest()->take(5)->get();

        // Get current month (e.g., "2025-07")
        $currentMonth = Carbon::now()->format('Y-m');

        // Filter payments for the current month
        $currentMonthPayments = Payment::where('month_for', $currentMonth)->get();
        $totalCommission = $currentMonthPayments->sum('commission_amount');


        $paymentsTotal = $currentMonthPayments->sum('amount');
        $paidUnits = $currentMonthPayments->pluck('unit_id')->unique()->count();

        $occupiedUnitIds = Unit::where('status', 'occupied')->pluck('id')->toArray();
        $paidUnitIds = $currentMonthPayments->pluck('unit_id')->unique()->filter()->toArray();
        $unpaidUnits = count(array_diff($occupiedUnitIds, $paidUnitIds));


        return view('dashboard', compact(
            'landlords', 'buildings', 'units', 'unitsVacant', 'unitsOccupied',
            'tenants', 'latestTenants',
            'paymentsTotal', 'paidUnits', 'unpaidUnits', 'totalCommission'
        ));
    }
}
// This controller handles the dashboard view and aggregates data from the models.