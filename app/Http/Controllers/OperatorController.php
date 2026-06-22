<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Tim;
use App\Models\HistoriSkor;
use App\Events\SkorDiupdate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class OperatorController extends Controller
{
    public function index()
    {
        $lombas = Lomba::latest()->get();
        return view('dashboard', compact('lombas'));
    }

    public function storeLomba(Request $request)
    {
        $request->validate(['nama_lomba' => 'required|string|max:255']);
        Lomba::create([
            'nama_lomba' => $request->nama_lomba,
            'juri_token' => Str::random(10),
            'sesi_state' => 'persiapan',
            'nomor_soal' => 0,
        ]);
        return redirect()->route('dashboard')->with('success', 'Lomba berhasil dibuat!');
    }

    public function show($id)
    {
        $lomba = Lomba::with('tims')->findOrFail($id);
        return view('operator.show', compact('lomba')); 
    }

    public function storeTim(Request $request, $id)
    {
        $lomba = Lomba::findOrFail($id);
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'ketua' => 'required|string|max:255',
            'anggota' => 'nullable|string',
        ]);
        $lomba->tims()->create([
            'nama_tim' => $request->nama_tim, 'ketua' => $request->ketua, 'anggota' => $request->anggota, 'skor' => 0,
        ]);
        return redirect()->back()->with('success', 'Tim berhasil ditambahkan!');
    }

    public function panel($id)
    {
        $lomba = Lomba::with('tims')->findOrFail($id);
        return view('operator.panel', compact('lomba'));
    }

    // Fungsi: Menambah/Mengurangi Skor (Misal: +100 atau -50)
    public function updateSkor(Request $request, $id, $timId)
    {
        $lomba = Lomba::findOrFail($id);
        $tim = $lomba->tims()->findOrFail($timId);
        
        $tim->skor += (int) $request->nilai;
        $tim->save();

        event(new SkorDiupdate($lomba->id, $tim->id, $tim->skor));
        return response()->json(['status' => 'success', 'skor_baru' => $tim->skor]);
    }

    // Fungsi: Menimpa/Mengubah Skor Langsung (Misal: Ubah jadi 1500)
    public function setSkor(Request $request, $id, $timId)
    {
        $lomba = Lomba::findOrFail($id);
        $tim = $lomba->tims()->findOrFail($timId);
        
        $tim->skor = (int) $request->nilai;
        $tim->save();

        event(new SkorDiupdate($lomba->id, $tim->id, $tim->skor));
        return response()->json(['status' => 'success', 'skor_baru' => $tim->skor]);
    }

    // Fungsi: Mereset Semua Nilai ke 0
    public function resetSkor($id)
    {
        $lomba = Lomba::findOrFail($id);
        foreach($lomba->tims as $tim) {
            $tim->skor = 0;
            $tim->save();
            event(new SkorDiupdate($lomba->id, $tim->id, 0));
        }
        return response()->json(['status' => 'success']);
    }

    public function display($id)
    {
        $lomba = Lomba::with('tims')->findOrFail($id);
        return view('lomba_display', compact('lomba'));
    }

    // ========================================================
    // 5. HAPUS LOMBA
    // ========================================================
    public function destroy($id)
    {
        $lomba = Lomba::findOrFail($id);
        
        // Hapus semua data tim yang terkait dengan lomba ini
        $lomba->tims()->delete();
        
        // Hapus histori skor (jika ada)
        HistoriSkor::where('lomba_id', $lomba->id)->delete();
        
        // Hapus data lomba utama
        $lomba->delete();

        return redirect()->route('dashboard')->with('success', 'Perlombaan beserta semua data tim berhasil dihapus permanen!');
    }

    // ========================================================
    // FITUR LOMBA DAKWAH
    // ========================================================
    public function dakwahPanel($id)
    {
        $lomba = Lomba::with('tims')->findOrFail($id);
        return view('operator.dakwah_panel', compact('lomba'));
    }

    public function dakwahDisplay($id)
    {
        $lomba = Lomba::findOrFail($id);
        return view('dakwah_display', compact('lomba'));
    }

    // ========================================================
    // FITUR LOMBA MUDZAKARAH (BACA KITAB)
    // ========================================================
    public function mudzakarahPanel($id)
    {
        $lomba = Lomba::with('tims')->findOrFail($id);
        return view('operator.mudzakarah_panel', compact('lomba'));
    }

    public function mudzakarahDisplay($id)
    {
        $lomba = Lomba::findOrFail($id);
        return view('mudzakarah_display', compact('lomba'));
    }

    // ========================================================
    // LOGIKA MASTER CLOCK & SINKRONISASI PERMANEN
    // ========================================================
    public function bumperSync(Request $request)
    {
        // Simpan status bumper di Cache server secara global
        Cache::forever('bumper_status', $request->status);
        event(new \App\Events\BumperUpdated($request->status));
        return response()->json(['status' => 'success']);
    }

    public function dakwahSync(Request $request, $id)
    {
        $lomba = Lomba::findOrFail($id);
        
        if ($request->status === 'start') {
            if ($lomba->dakwah_status !== 'start') { // Cegah double klik start
                if ($lomba->dakwah_status === 'reset') { $lomba->dakwah_waktu = $request->waktu; }
                $lomba->dakwah_last_start = now(); // Catat waktu asli server saat ini
            }
        } 
        elseif ($request->status === 'pause') {
            // Jika dipause, hitung waktu yang sudah berjalan dan simpan sisa pastinya
            if ($lomba->dakwah_status === 'start' && $lomba->dakwah_last_start) {
                $elapsed = now()->diffInSeconds($lomba->dakwah_last_start);
                $lomba->dakwah_waktu = max(0, $lomba->dakwah_waktu - $elapsed);
            }
        }
        elseif ($request->status === 'reset') {
            $lomba->dakwah_waktu = $request->waktu;
        }

        if ($request->status !== 'sync') { $lomba->dakwah_status = $request->status; }
        $lomba->dakwah_peserta = $request->nama_peserta;
        $lomba->save();

        event(new \App\Events\DakwahUpdated($id, $request->status, $lomba->dakwah_waktu, $request->nama_peserta));
        return response()->json(['status' => 'success']);
    }

    public function mudzakarahSync(Request $request, $id)
    {
        $lomba = Lomba::findOrFail($id);
        
        if ($request->status === 'start') {
            if ($lomba->mudzakarah_status !== 'start') {
                if ($lomba->mudzakarah_status === 'reset') { $lomba->mudzakarah_waktu = $request->waktu; }
                $lomba->mudzakarah_last_start = now();
            }
        } 
        elseif ($request->status === 'pause') {
            if ($lomba->mudzakarah_status === 'start' && $lomba->mudzakarah_last_start) {
                $elapsed = now()->diffInSeconds($lomba->mudzakarah_last_start);
                $lomba->mudzakarah_waktu = max(0, $lomba->mudzakarah_waktu - $elapsed);
            }
        }
        elseif ($request->status === 'reset') {
            $lomba->mudzakarah_waktu = $request->waktu;
        }

        if ($request->status !== 'sync') { $lomba->mudzakarah_status = $request->status; }
        $lomba->mudzakarah_peserta = $request->nama_peserta;
        $lomba->save();

        event(new \App\Events\MudzakarahUpdated($id, $request->status, $lomba->mudzakarah_waktu, $request->nama_peserta));
        return response()->json(['status' => 'success']);
    }
}