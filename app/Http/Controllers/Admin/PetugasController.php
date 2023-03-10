<?php

namespace App\Http\Controllers\Admin;

use App\Models\Petugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::all();

        return view('Admin.Petugas.index', ['petugas' => $petugas]);
    }

    public function create()
    {
        return view('Admin.Petugas.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);

        $validate = Validator::make($data, [
            'nama_petugas' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'unique:petugas'],
            'password' => ['required', 'string', 'min:6'],
            'telp' => ['required'],
            'level' => ['required', 'in:admin,petugas'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $username = Petugas::where('username', $data['username'])->get();
        // dd($username);

        if ($username) {
            return redirect()->back()->with(['username' => 'Username Sudah Dipakai!']);
        }

        Petugas::create([
            'nama_petugas' => $data['nama_petugas'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'telp' => $data['telp'],
            'level' => $data['level'],
        ]);
        if(session('status' == 200)){
            return redirect()->route('petugas.index');
        }
            return 'gagal';
    }

    public function edit($id_petugas)
    {
        return view('Admin.Petugas.edit');
    }

    public function update(Request $request, $id_petugas)
    {

    }

    public function destroy($id_petugas)
    {

    }
}
