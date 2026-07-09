<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HospitalController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/hospitals/index', [
            'hospitals' => Hospital::withCount('donors')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/hospitals/form', [
            'hospital' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', 'unique:hospitals'],
        ]);

        Hospital::create($validated);

        return redirect()->route('admin.hospitals.index')->with('success', 'Hospital created.');
    }

    public function edit(Hospital $hospital): Response
    {
        return Inertia::render('admin/hospitals/form', [
            'hospital' => $hospital,
        ]);
    }

    public function update(Request $request, Hospital $hospital): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', 'unique:hospitals,code,'.$hospital->id],
        ]);

        $hospital->update($validated);

        return redirect()->route('admin.hospitals.index')->with('success', 'Hospital updated.');
    }

    public function destroy(Hospital $hospital): RedirectResponse
    {
        $hospital->delete();

        return redirect()->route('admin.hospitals.index')->with('success', 'Hospital deleted.');
    }
}
