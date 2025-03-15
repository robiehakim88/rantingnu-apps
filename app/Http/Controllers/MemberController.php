<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Role;

class MemberController extends Controller
{
    // Method-method CRUD (index, create, store, edit, update, destroy)
   public function index(Request $request)
    {
        // Ambil nilai query 'search' dari request
        $search = $request->input('search');
    
        // Query untuk mengambil data anggota
        $query = Member::with('role');
    
        // Jika ada input pencarian, tambahkan kondisi where
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
    
        // Eksekusi query dan tampilkan hasilnya
        $members = $query->get();
    
        return view('members.index', compact('members', 'search'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('members.create', compact('roles'));
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female', // Validasi untuk jenis kelamin
            'email' => 'required|email|unique:members',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'date_of_birth' => 'nullable|date', // Validasi untuk tanggal lahir
        ]);
        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        $roles = Role::all();
        return view('members.edit', compact('member', 'roles'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female', // Validasi untuk jenis kelamin
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'date_of_birth' => 'nullable|date', // Validasi untuk tanggal lahir
        ]);

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}