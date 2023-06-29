<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
 
class mahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 10;
        if(strlen($katakunci)){
            $data = mahasiswa::where('nim','like',"%$katakunci%")->orWhere('nama','like',"%$katakunci%")->orWhere('jurusan','like',"%$katakunci%")->paginate($jumlahbaris);
        }else{
             $data = mahasiswa::sortable()->paginate(10);
        }

        return view('mahasiswa.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        FacadesSession::flash('nim',$request->nim);
        FacadesSession::flash('nama',$request->nama);
        FacadesSession::flash('jurusan',$request->jurusan);

        $request->validate([
            'nim'=>'required|numeric|unique:mahasiswa,nim',
            'nama'=>'required',
            'jurusan'=>'required',
        ],[
            'nim.required'=>'NIM wajib diisi',
            'nim.numeric'=>'NIM wajib diisi dalam angka',
            'nim.unique'=>'NIM sudah ada di dalam database',
            'nama.required'=>'NAMA wajib diisi',
            'jurusan.required'=>'JURUSAN wajib diisi',
        ]);
        $data = [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan];
            mahasiswa::create ($data);
        return redirect()-> to('mahasiswa')->with('success','Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = mahasiswa::where('nim',$id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama'=>'required',
            'jurusan'=>'required',
        ],[
            'nama.required'=>'NAMA wajib diisi',
            'jurusan.required'=>'JURUSAN wajib diisi',
        ]);
        $data = [
            'nama' => $request->nama,
            'jurusan' => $request->jurusan];
            mahasiswa::where('nim',$id)->update($data) ;
        return redirect()-> to('mahasiswa')->with('success','Berhasil mengupdate data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        mahasiswa::where('nim',$id)->delete();
        return redirect()->to('mahasiswa')->with('success','Berhasil mendelete data');
    }
}
