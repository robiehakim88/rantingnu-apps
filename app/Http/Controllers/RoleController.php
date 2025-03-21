<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // Tidak menggunakan middleware di constructor, definisikan langsung di route

    // Menampilkan daftar roles
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Role::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $roles = $query->get();
        return view('roles.index', compact('roles', 'search'));
    }

    // Menampilkan form tambah role
    public function create()
    {
        return view('roles.create');
    }

    // Menyimpan data role baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
    }

    // Menampilkan detail role
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    // Menampilkan form edit role
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    // Memperbarui data role
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    // Menghapus role
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}