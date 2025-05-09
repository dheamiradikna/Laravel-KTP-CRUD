<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ktp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;

class KtpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ktps = Ktp::all();
        return response()->json([
            'success' => true,
            'data' => $ktps,
            'message' => 'Data KTP berhasil diambil'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'rt_rw' => 'required|string|max:10',
            'kelurahan_desa' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'agama' => 'required|string|max:20',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:50',
            'kewarganegaraan' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $nik = $this->generateUniqueNIK();

        $data = $request->all();
        $data['nik'] = $nik;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/fotos', $filename);
            $data['foto'] = $filename;
        }

        $ktp = Ktp::create($data);

        $this->logActivity('API: Membuat KTP baru dengan NIK: ' . $ktp->nik);

        return response()->json([
            'success' => true,
            'data' => $ktp,
            'message' => 'KTP berhasil dibuat'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ktp = Ktp::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $ktp,
            'message' => 'Data KTP berhasil diambil'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'rt_rw' => 'required|string|max:10',
            'kelurahan_desa' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'agama' => 'required|string|max:20',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:50',
            'kewarganegaraan' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ktp = Ktp::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($ktp->foto) {
                Storage::delete('public/fotos/' . $ktp->foto);
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/fotos', $filename);
            $data['foto'] = $filename;
        }

        $ktp->update($data);

        $this->logActivity('API: Mengupdate KTP dengan NIK: ' . $ktp->nik);

        return response()->json([
            'success' => true,
            'data' => $ktp,
            'message' => 'KTP berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ktp = Ktp::findOrFail($id);
        
        if ($ktp->foto) {
            Storage::delete('public/fotos/' . $ktp->foto);
        }
        
        $nik = $ktp->nik;
        $ktp->delete();

        $this->logActivity('API: Menghapus KTP dengan NIK: ' . $nik);

        return response()->json([
            'success' => true,
            'message' => 'KTP berhasil dihapus'
        ]);
    }

    /**
     * Generate a unique NIK
     */
    private function generateUniqueNIK()
    {
        do {
            $nik = mt_rand(1000000000000000, 9999999999999999);
        } while (Ktp::where('nik', $nik)->exists());

        return (string) $nik;
    }

    /**
     * Log user activity
     */
    private function logActivity($description)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'description' => $description,
        ]);
    }
}
