<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Inertia\Inertia;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();

        return Inertia::render('Mahasiswa/Index', ['mahasiswa' => $mahasiswa]);
    }

    public function formAdd(){
        return Inertia::render('Mahasiswa/FormTambah');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'tnpm' => 'required|unique:mahasiswa,npm|max:7',
            'tnama' => 'required',
            'tjk' => 'required',
            'talamat' => 'required',
        ],[], [
            'tnpm' => 'NPM',
            'tnama' => 'Nama Lengkap',
            'tjk' => 'Jenis Kelamin',
            'talamat' => 'Alamat Lengkap',
        ]);

        $mahasiswa = new Mahasiswa();

        $mahasiswa->npm = $validateData['tnpm'];
        $mahasiswa->nama_lengkap = $validateData['tnama'];
        $mahasiswa->jk = $validateData['tjk'];
        $mahasiswa->alamat = $validateData['talamat'];
        $mahasiswa->save();

        return redirect()->route('mahasiswa.index')->with('message','Data Mahasiswa Baru Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if($mahasiswa){
            return Inertia::render('Mahasiswa/FormEdit', [
                'id' => $id,
                'mhs'=> $mahasiswa
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'tnama' => 'required',
            'tjk' => 'required',
            'talamat' => 'required',
        ],[], [
            'tnama' => 'Nama Lengkap',
            'tjk' => 'Jenis Kelamin',
            'talamat' => 'Alamat Lengkap',
        ]);

        $mahasiswa = Mahasiswa::find($id);
        $mahasiswa->nama_lengkap = $validateData['tnama'];
        $mahasiswa->jk = $validateData['tjk'];
        $mahasiswa->alamat = $validateData['talamat'];
        $mahasiswa->save();

        return redirect()->route('mahasiswa.index')->with('message','Data Mahasiswa dengan NPM :'. $mahasiswa->npm .' berhasil diupdate...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $npm = $mahasiswa->npm;
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('message', 'Data Dengan NPM : '. $npm .' berhasil dihapus');
    }
}