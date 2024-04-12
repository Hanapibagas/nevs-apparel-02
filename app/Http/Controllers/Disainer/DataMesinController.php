<?php

namespace App\Http\Controllers\Disainer;

use App\Http\Controllers\Controller;
use App\Models\BarangMasukMesin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataMesinController extends Controller
{
    public function getDataMesinAtexco()
    {
        $user = Auth::user();
        $mesin = BarangMasukMesin::whereHas('user', function ($query) {
            $query->where('roles', 'atexco');
        })
            ->with('User')
            ->where('users_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // return response()->json($mesin);

        return view('component.Disainer.data-mesin-atexco-disainer.index', compact('mesin'));
    }

    public function getDataMesinMimaki()
    {
        $user = Auth::user();
        $mesin = BarangMasukMesin::whereHas('user', function ($query) {
            $query->where('roles', 'mimaki');
        })
            ->with('User')
            ->where('users_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('component.Disainer.data-mesin-mimaki-disainer.index', compact('mesin'));
    }
}
