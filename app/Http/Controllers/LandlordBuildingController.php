<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use App\Models\Building;
use Illuminate\Http\Request;

class LandlordBuildingController extends Controller
{
    public function landlordIndex(Request $request)
    {
        $query = Landlord::query();

        if ($search = $request->input('search')) {
            $query->where('full_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('id_number', 'like', "%$search%");
        }

        $landlords = $query->latest()->paginate(10);
        return view('landlords.index', compact('landlords'));
    }

    public function exportLandlords()
    {
        $landlords = Landlord::all();

        $csvHeader = ['Full Name', 'Email', 'Phone', 'ID Number'];

        $callback = function () use ($landlords, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);

            foreach ($landlords as $landlord) {
                fputcsv($file, [
                    $landlord->full_name,
                    $landlord->email,
                    $landlord->phone,
                    $landlord->id_number
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=landlords.csv'
        ]);
    }

    public function buildingIndex(Request $request)
    {
        $query = Building::with('landlord');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('city', 'like', "%$search%")
                  ->orWhere('town', 'like', "%$search%")
                  ->orWhereHas('landlord', function ($q) use ($search) {
                      $q->where('full_name', 'like', "%$search%");
                  });
        }

        $buildings = $query->latest()->paginate(10);
        return view('buildings.index', compact('buildings'));
    }

    public function exportBuildings()
    {
        $buildings = Building::with('landlord')->get();

        $csvHeader = ['Building Name', 'City', 'Town', 'Landlord'];

        $callback = function () use ($buildings, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);

            foreach ($buildings as $building) {
                fputcsv($file, [
                    $building->name,
                    $building->city,
                    $building->town,
                    optional($building->landlord)->full_name
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=buildings.csv'
        ]);
    }
}
