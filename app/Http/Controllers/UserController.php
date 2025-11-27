<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('super-admin')) {
            $query = User::with(['organization', 'roles'])->latest();

            if ($request->has('organization_id') && $request->organization_id != '') {
                $query->where('organization_id', $request->organization_id);
            }

            $users = $query->get();
            $organizations = Organization::all(); // For filter dropdown
        } else {
            $users = User::with(['organization', 'roles'])
                ->where('organization_id', $user->organization_id)
                ->latest()
                ->get();
            $organizations = collect([]);
        }

        return view('users.index', compact('users', 'organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('super-admin')) {
            $organizations = Organization::all();
            $roles = Role::all();
        } else {
            $organizations = collect([$user->organization]);
            $roles = Role::where('name', 'user')->get();
        }

        return view('users.create', compact('organizations', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'organization_id' => ['nullable', 'exists:organizations,id'],
        ]);

        // If admin, force organization_id to own organization
        if ($user->hasRole('admin')) {
            $request->merge(['organization_id' => $user->organization_id]);

            // Admin can only create 'user' role
            if ($request->role !== 'user') {
                return back()->withErrors(['role' => 'Anda hanya dapat membuat user biasa.']);
            }
        }

        // Check if organization_id is required (if role is not super-admin)
        if ($request->role !== 'super-admin' && !$request->organization_id) {
            return back()->withErrors(['organization_id' => 'Organisasi wajib dipilih untuk role ini.']);
        }

        // Validate 1 Organization = 1 Admin
        if ($request->role == 'admin') {
            $existingAdmin = User::role('admin')
                ->where('organization_id', $request->organization_id)
                ->exists();

            if ($existingAdmin) {
                return back()->withErrors(['organization_id' => 'Organisasi ini sudah memiliki Admin.']);
            }
        }

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $request->organization_id,
        ]);

        $newUser->assignRole($request->role);

        return redirect()->route($user->hasRole('super-admin') ? 'super.users.index' : 'admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Check access
        if (auth()->user()->hasRole('admin') && $user->organization_id !== auth()->user()->organization_id) {
            abort(403);
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $currentUser = auth()->user();

        // Check access
        if ($currentUser->hasRole('admin')) {
            if ($user->organization_id !== $currentUser->organization_id) {
                abort(403);
            }
            // Admin cannot edit super-admin or other admins (unless self, but usually admin manages users)
            // Requirement: Admin manages "user biasa".
            if ($user->hasRole('super-admin') || ($user->hasRole('admin') && $user->id !== $currentUser->id)) {
                // Actually admin manages users. Can admin edit themselves? Maybe profile.
                // But here we are talking about CRUD Users.
                // "Mengelola user biasa dalam organisasinya."
                if ($user->hasRole('admin')) {
                    abort(403, 'Anda tidak dapat mengedit sesama admin.');
                }
            }
        }

        if ($currentUser->hasRole('super-admin')) {
            $organizations = Organization::all();
            $roles = Role::all();
        } else {
            $organizations = collect([$currentUser->organization]);
            $roles = Role::where('name', 'user')->get();
        }

        return view('users.edit', compact('user', 'organizations', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();

        // Check access
        if ($currentUser->hasRole('admin')) {
            if ($user->organization_id !== $currentUser->organization_id) {
                abort(403);
            }
            if ($user->hasRole('super-admin') || ($user->hasRole('admin') && $user->id !== $currentUser->id)) {
                if ($user->hasRole('admin')) {
                    abort(403, 'Anda tidak dapat mengedit sesama admin.');
                }
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', 'exists:roles,name'],
            'organization_id' => ['nullable', 'exists:organizations,id'],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', 'min:8'],
            ]);
        }

        // If admin, force organization_id to own organization
        if ($currentUser->hasRole('admin')) {
            $request->merge(['organization_id' => $currentUser->organization_id]);
            if ($request->role !== 'user') {
                return back()->withErrors(['role' => 'Anda hanya dapat membuat user biasa.']);
            }
        }

        // Check if organization_id is required
        if ($request->role !== 'super-admin' && !$request->organization_id) {
            return back()->withErrors(['organization_id' => 'Organisasi wajib dipilih untuk role ini.']);
        }

        // Validate 1 Organization = 1 Admin
        if ($request->role == 'admin') {
            $existingAdmin = User::role('admin')
                ->where('organization_id', $request->organization_id)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($existingAdmin) {
                return back()->withErrors(['organization_id' => 'Organisasi ini sudah memiliki Admin.']);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->organization_id = $request->organization_id;
        $user->save();

        $user->syncRoles([$request->role]);

        return redirect()->route($currentUser->hasRole('super-admin') ? 'super.users.index' : 'admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();

        // Check access
        if ($currentUser->hasRole('admin')) {
            if ($user->organization_id !== $currentUser->organization_id) {
                abort(403);
            }
            if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
                abort(403, 'Anda tidak dapat menghapus admin/superadmin.');
            }
        }

        if ($user->id === $currentUser->id) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus diri sendiri.']);
        }

        $user->delete();

        return redirect()->route($currentUser->hasRole('super-admin') ? 'super.users.index' : 'admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
