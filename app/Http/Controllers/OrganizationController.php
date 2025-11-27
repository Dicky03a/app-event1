<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the organizations.
     */
    public function index()
    {
        // Super Admin can see all organizations
        // Admin can only see their own organization
        $organizations = auth()->user()->isSuperAdmin()
            ? Organization::with('creator')->latest()->get()
            : Organization::where('id', auth()->user()->organization_id)->with('creator')->get();

        return view('organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new organization.
     */
    public function create()
    {
        return view('organizations.create');
    }

    /**
     * Store a newly created organization in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Generate slug from name
        $validated['slug'] = Str::slug($request->name);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Set created_by to current user
        $validated['created_by'] = auth()->id();

        Organization::create($validated);

        return redirect()->route('super.organizations.index')
            ->with('success', 'Organisasi berhasil dibuat.');
    }

    /**
     * Display the specified organization.
     */
    public function show(Organization $organization)
    {
        // Check if user has permission to view this organization
        if (!auth()->user()->isSuperAdmin() && auth()->user()->organization_id !== $organization->id) {
            abort(403, 'Unauthorized action.');
        }

        $organization->load('creator', 'users', 'events');

        return view('organizations.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified organization.
     */
    public function edit(Organization $organization)
    {
        // Check if user has permission to edit this organization
        if (!auth()->user()->isSuperAdmin() && auth()->user()->organization_id !== $organization->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('organizations.edit', compact('organization'));
    }

    /**
     * Update the specified organization in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        // Check if user has permission to update this organization
        if (!auth()->user()->isSuperAdmin() && auth()->user()->organization_id !== $organization->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Update slug if name changed
        if ($request->name !== $organization->name) {
            $validated['slug'] = Str::slug($request->name);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($organization->logo) {
                Storage::disk('public')->delete($organization->logo);
            }
            $validated['logo'] = $request->file('logo')->store('organizations/logos', 'public');
        }

        $organization->update($validated);

        $route = auth()->user()->isSuperAdmin() ? 'super.organizations.index' : 'admin.organizations.index';
        return redirect()->route($route)
            ->with('success', 'Organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified organization from storage.
     */
    public function destroy(Organization $organization)
    {
        // Only Super Admin can delete organizations
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete logo if exists
        if ($organization->logo) {
            Storage::disk('public')->delete($organization->logo);
        }

        $organization->delete();

        return redirect()->route('super.organizations.index')
            ->with('success', 'Organisasi berhasil dihapus.');
    }
}
