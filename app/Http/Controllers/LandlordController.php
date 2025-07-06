<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use Illuminate\Http\Request;

class LandlordController extends Controller
{
    public function index()
    {
        $landlords = Landlord::latest()->paginate(10);
        return view('landlords.index', compact('landlords'));
    }

    public function create()
    {
        return view('landlords.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:landlords,email',
            'id_number' => 'required|string|max:50',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Landlord::create($validated);
        return redirect()->route('landlords.index')->with('success', 'Landlord added.');
    }

    public function show(Landlord $landlord)
    {
        return view('landlords.show', compact('landlord'));
    }

    public function edit(Landlord $landlord)
    {
        return view('landlords.edit', compact('landlord'));
    }

    public function update(Request $request, Landlord $landlord)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:landlords,email,' . $landlord->id,
            'id_number' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $landlord->update($validated);
        return redirect()->route('landlords.index')->with('success', 'Landlord updated.');
    }

    public function destroy(Landlord $landlord)
    {
        $landlord->delete();
        return redirect()->route('landlords.index')->with('success', 'Landlord deleted.');
    }
}
