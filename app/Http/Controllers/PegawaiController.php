<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PegawaiController extends Controller
{
    public function index()
    {
        if (!in_array(Auth::user()->role, ['owner', 'manager'])) {
            abort(403, 'Akses ditolak.');
        }

        $query = User::with('cabang')->orderBy('role', 'asc');

        if (Auth::user()->role !== 'owner') {
            $query->where('role', '!=', 'owner');
        }

        $pegawais = $query->get();

        return view('master.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['owner', 'manager'])) {
            abort(403, 'Akses ditolak.');
        }

        $cabangs = Cabang::all();

        return view('master.pegawai.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['owner', 'manager'])) {
            abort(403, 'Akses ditolak.');
        }

        if ($request->role === 'owner' && Auth::user()->role !== 'owner') {
            return redirect()->back()->with('error', 'Hanya Owner yang berhak membuat akun Owner baru!');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
            'cabang_id' => ['nullable', 'exists:cabangs,id'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'cabang_id' => $request->cabang_id,
        ]);

        return redirect()->route('master.pegawai')->with('success', 'Akun pegawai baru berhasil dibuat.');
    }

    public function edit($id)
    {
        if (!in_array(Auth::user()->role, ['owner', 'manager'])) {
            abort(403, 'Akses ditolak.');
        }

        $pegawai = User::findOrFail($id);

        if ($pegawai->role === 'owner' && Auth::user()->role !== 'owner') {
            return redirect()->route('master.pegawai')->with('error', 'Anda tidak memiliki akses untuk mengedit akun Owner!');
        }

        $cabangs = Cabang::all();

        return view('master.pegawai.edit', compact('pegawai', 'cabangs'));
    }

    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['owner', 'manager'])) {
            abort(403, 'Akses ditolak.');
        }

        $pegawai = User::findOrFail($id);

        if (($request->role === 'owner' || $pegawai->role === 'owner') && Auth::user()->role !== 'owner') {
            return redirect()->route('master.pegawai')->with('error', 'Akses ditolak. Tindakan ilegal terdeteksi!');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $pegawai->id],
            'role' => ['required', 'string'],
            'cabang_id' => ['nullable', 'exists:cabangs,id'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $pegawai->name = $request->name;
        $pegawai->email = $request->email;
        $pegawai->role = $request->role;
        $pegawai->cabang_id = $request->cabang_id;

        if ($request->filled('password')) {
            $pegawai->password = Hash::make($request->password);
        }

        $pegawai->save();

        return redirect()->route('master.pegawai')->with('success', 'Data akun pegawai berhasil diupdate.');
    }

    public function destroy($id)
    {
        if (!in_array(Auth::user()->role, ['owner', 'manager'])) {
            abort(403, 'Akses ditolak.');
        }

        $pegawai = User::findOrFail($id);

        if ($pegawai->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
        }

        if ($pegawai->role === 'owner' && Auth::user()->role !== 'owner') {
            return redirect()->route('master.pegawai')->with('error', 'Akses ditolak. Anda tidak bisa menghapus akun Owner!');
        }

        $pegawai->delete();

        return redirect()->route('master.pegawai')->with('success', 'Akun pegawai berhasil dihapus.');
    }
}