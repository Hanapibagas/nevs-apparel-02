<?php

namespace App\Http\Controllers\Disainer;

use App\Http\Controllers\Controller;
use App\Models\BahanCetak;
use App\Models\BahanKain;
use App\Models\KeraBaju;
use App\Models\PolaCeleana;
use App\Models\PolaLengan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListDataController extends Controller
{
    public function getIndexLisDataJenisKerah()
    {
        $jenisKerah = KeraBaju::where('id', '>', '1')->get();

        return view('component.Disainer.list-data-jenis-kera-disainer-pegawai.index', compact('jenisKerah'));
    }

    public function getIndexLisDataJenisLengan()
    {
        $jenisKerah = PolaLengan::where('id', '>', 1)->get();

        return view('component.Disainer.list-data-jenis-lengan-disainer-pegawai.index', compact('jenisKerah'));
    }

    public function getIndexLisDataJenisCelana()
    {
        $jenisKerah = PolaCeleana::where('id', '>', '1')->get();

        return view('component.Disainer.list-data-jenis-celana-disainer-pegawai.index', compact('jenisKerah'));
    }

    public function postDataJenisKerah(Request $request)
    {
        $this->validate($request, [
            'jenis_kera' => 'required',
        ]);

        if ($request->file('gambar')) {
            $filebaju = $request->file('gambar')->store('data-jenis-kera', 'public');
        }

        KeraBaju::create([
            'jenis_kera' => $request->jenis_kera,
            'status' => $request->status,
            'gambar' => $filebaju
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function getIndexBahanKain()
    {
        $bahankain = BahanKain::all();

        return view('component.Disainer.list-data-bahan-kain-disainer-pegawai.index', compact('bahankain'));
    }

    public function postBahanKain(Request $request)
    {
        BahanKain::create([
            'nama' => $request->nama
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function putBahanKain(Request $request, $id)
    {
        $update = BahanKain::find($id);

        $update->update([
            'nama' => $request->nama
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input diperbarui!');
    }

    public function getIndexBahanKertas()
    {
        $bahankain = BahanCetak::all();

        return view('component.Disainer.list-data-bahan-kertas-disainer-pegawai.index', compact('bahankain'));
    }

    public function postBahanCetak(Request $request)
    {
        BahanCetak::create([
            'nama' => $request->nama
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function putBahanCetak(Request $request, $id)
    {
        $update = BahanCetak::find($id);

        $update->update([
            'nama' => $request->nama
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input diperbarui!');
    }

    public function postDataJenisCelana(Request $request)
    {
        $this->validate($request, [
            'jenis_kera' => 'required',
        ]);

        if ($request->file('gambar')) {
            $filebaju = $request->file('gambar')->store('data-jenis-celana', 'public');
        }

        PolaCeleana::create([
            'jenis_kera' => $request->jenis_kera,
            'gambar' => $filebaju
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function postDataJenisLengan(Request $request)
    {
        $this->validate($request, [
            'jenis_kera' => 'required',
        ]);

        if ($request->file('gambar')) {
            $filebaju = $request->file('gambar')->store('data-jenis-lengan', 'public');
        }

        PolaLengan::create([
            'jenis_kera' => $request->jenis_kera,
            'status' => $request->status,
            'gambar' => $filebaju
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function putDataJenisKerah(Request $request, $id)
    {
        $update = KeraBaju::find($id);

        if ($request->file('gambar')) {
            $filebaju = $request->file('gambar')->store('data-jenis-kera', 'public');
            if ($update->gambar && file_exists(storage_path('app/public/' . $update->gambar))) {
                Storage::delete('public/' . $update->gambar);
                $filebaju = $request->file('gambar')->store('data-jenis-kera', 'public');
            }
        }

        if ($request->file('gambar') === null) {
            $filebaju = $update->gambar;
        }

        $update->update([
            'jenis_kera' => $request->jenis_kera,
            'status' => $request->status,
            'gambar' => $filebaju
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function putDataJenisLengan(Request $request, $id)
    {
        $update = PolaLengan::find($id);

        if ($request->file('gambar')) {
            $filebaju = $request->file('gambar')->store('data-jenis-lengan', 'public');
            if ($update->gambar && file_exists(storage_path('app/public/' . $update->gambar))) {
                Storage::delete('public/' . $update->gambar);
                $filebaju = $request->file('gambar')->store('data-jenis-lengan', 'public');
            }
        }

        if ($request->file('gambar') === null) {
            $filebaju = $update->gambar;
        }

        $update->update([
            'jenis_kera' => $request->jenis_kera,
            'status' => $request->status,
            'gambar' => $filebaju
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function putDataJenisCelana(Request $request, $id)
    {
        $update = PolaCeleana::find($id);

        if ($request->file('gambar')) {
            $filebaju = $request->file('gambar')->store('data-jenis-celana', 'public');
            if ($update->gambar && file_exists(storage_path('app/public/' . $update->gambar))) {
                Storage::delete('public/' . $update->gambar);
                $filebaju = $request->file('gambar')->store('data-jenis-celana', 'public');
            }
        }

        if ($request->file('gambar') === null) {
            $filebaju = $update->gambar;
        }


        $update->update([
            'jenis_kera' => $request->jenis_kera,
            'gambar' => $filebaju
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function deletJenisDatakerah($id)
    {
        $delete = KeraBaju::find($id);
        if ($delete->gambar && file_exists(storage_path('app/public/' . $delete->gambar))) {
            Storage::delete('public/' . $delete->gambar);
        }

        $delete->delete();

        return response()->json(['success' => 'Data berhasil dihapus']);
    }

    public function deletJenisDataCelana($id)
    {
        $delete = PolaCeleana::find($id);
        if ($delete->gambar && file_exists(storage_path('app/public/' . $delete->gambar))) {
            Storage::delete('public/' . $delete->gambar);
        }

        $delete->delete();

        return response()->json(['success' => 'Data berhasil dihapus']);
    }

    public function deletJenisDataLengan($id)
    {
        $delete = PolaLengan::find($id);
        if ($delete->gambar && file_exists(storage_path('app/public/' . $delete->gambar))) {
            Storage::delete('public/' . $delete->gambar);
        }

        $delete->delete();

        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}
