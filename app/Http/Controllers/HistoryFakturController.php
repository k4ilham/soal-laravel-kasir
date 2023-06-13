<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryFakturBarangModel;
use App\Models\HistoryBarangModel;

class HistoryFakturController extends Controller
{
    public function index()
    {
        $historyFaktur = HistoryFakturBarangModel::with('historyBarang')->get();
        return view('history_faktur', compact('historyFaktur'));
    }

    public function loadBarang($fakturId)
    {
        $barang = HistoryBarangModel::with('barang')->where('id_faktur', $fakturId)->get();
        return response()->json(['data' => $barang]);
    }
}
