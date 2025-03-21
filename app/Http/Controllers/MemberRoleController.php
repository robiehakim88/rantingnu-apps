<?php

namespace App\Http\Controllers;



use App\Models\Member;
use App\Models\Role;
use App\Models\MemberRole;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf;

class MemberRoleController extends Controller
{
    // Halaman Index
    public function index(Request $request)
    {
        // Pencarian berdasarkan nama anggota
        $search = $request->input('search');
        $query = MemberRole::with(['member', 'role']);

        if ($search) {
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $memberRoles = $query->paginate(10)->withQueryString();

        return view('member_roles.index', compact('memberRoles', 'search'));
    }

    // Halaman Tambah Data
    public function create()
    {
        $members = Member::all();
        $roles = Role::all();
        return view('member_roles.create', compact('members', 'roles'));
    }

    // Simpan Data Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'role_id' => 'required|exists:roles,id',
            'start_year' => 'required|integer|min:2000|max:' . now()->year,
            'end_year' => 'required|integer|min:2000|max:' . now()->year,
        ]);

        MemberRole::create($validated);

        return redirect()->route('member-roles.index')->with('success', 'Data berhasil disimpan.');
    }

    // Edit Data
    public function edit(MemberRole $memberRole)
    {
        $members = Member::all();
        $roles = Role::all();
        return view('member_roles.edit', compact('memberRole', 'members', 'roles'));
    }

    // Update Data
    public function update(Request $request, MemberRole $memberRole)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'role_id' => 'required|exists:roles,id',
            'start_year' => 'required|integer|min:2000|max:' . now()->year,
            'end_year' => 'required|integer|min:2000|max:' . now()->year,
        ]);

        $memberRole->update($validated);

        return redirect()->route('member-roles.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Hapus Data
    public function destroy(MemberRole $memberRole)
    {
        $memberRole->delete();
        return redirect()->route('member-roles.index')->with('success', 'Data berhasil dihapus.');
    }

    // Cetak Piagam Penghargaan
 public function generateCertificate($memberId)
{
    $member = Member::findOrFail($memberId);
    $memberRoles = MemberRole::where('member_id', $memberId)->with('role')->get();

    // Load view dan set orientasi ke landscape
    $pdf = Pdf::loadView('certificates.member_certificate', compact('member', 'memberRoles'))
               ->setPaper('a4', 'landscape'); // Mengatur ukuran kertas dan orientasi

    return $pdf->download("piagam_penghargaan_{$member->name}.pdf");
}
    
    

 
}