<?php

namespace App\Http\Controllers;

use App\Models\Ktp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KtpsExport;
use App\Imports\KtpsImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;

class KtpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index', 'show', 'exportCsv', 'exportPdf']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ktps = Ktp::latest()->paginate(10);
        return view('ktps.index', compact('ktps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ktps.create');
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

        $this->logActivity('Membuat KTP baru dengan NIK: ' . $ktp->nik);

        return redirect()->route('ktps.index')
            ->with('success', 'KTP berhasil dibuat dengan NIK: ' . $ktp->nik);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ktp = Ktp::findOrFail($id);
        return view('ktps.show', compact('ktp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ktp = Ktp::findOrFail($id);
        return view('ktps.edit', compact('ktp'));
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

        $this->logActivity('Mengupdate KTP dengan NIK: ' . $ktp->nik);

        return redirect()->route('ktps.index')
            ->with('success', 'KTP berhasil diperbarui');
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

        $this->logActivity('Menghapus KTP dengan NIK: ' . $nik);

        return redirect()->route('ktps.index')
            ->with('success', 'KTP berhasil dihapus');
    }

    /**
     * Export KTP data to CSV
     */
    public function exportCsv()
    {
        $this->logActivity('Mengekspor data KTP ke CSV');
        
        return Excel::download(new KtpsExport, 'ktps.csv');
    }

    /**
     * Export KTP data to PDF
     */
    public function exportPdf()
    {
        $ktps = Ktp::all();
        
        $this->logActivity('Mengekspor data KTP ke PDF');
        
        $pdf = PDF::loadView('ktps.pdf', compact('ktps'));
        return $pdf->download('ktps.pdf');
    }

    /**
     * Import KTP data from CSV
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:10240',
        ]);

        Excel::import(new KtpsImport, $request->file('file'));

        $this->logActivity('Mengimpor data KTP dari CSV');

        return redirect()->route('ktps.index')
            ->with('success', 'Data KTP berhasil diimpor');
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
