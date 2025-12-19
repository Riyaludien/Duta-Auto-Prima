<?php

namespace App\Http\Controllers;

use App\Models\LogStok;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\User;

class LogStokController extends Controller
{
    public function index(Request $request)
    {
        $query = LogStok::with(['barang', 'user']);

        if ($request->barang_id) {
            $query->where('barang_id', $request->barang_id);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->latest()->paginate(15)->withQueryString();
        $barangs = Barang::all();
        $users = User::all();

        // ⚡ Kirim juga nilai filter ke view
        $barang_id = $request->barang_id;
        $user_id = $request->user_id;

        return view('log_stoks.index', compact('logs', 'barangs', 'users', 'barang_id', 'user_id'));
    }


}
