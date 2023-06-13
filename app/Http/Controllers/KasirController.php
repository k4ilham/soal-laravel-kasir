<?php

namespace App\Http\Controllers;

use App\Models\KasirModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use App\Models\HistoryBarangModel;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryFakturBarangModel;
use Illuminate\Support\Facades\Session;

class KasirController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function getKasir($kodeKasir)
    {
        // Mengambil data Kasir berdasarkan Kode Kasir
        $kasir = KasirModel::where('kode_kasir', $kodeKasir)->first();
        return response()->json(['nama_kasir' => $kasir->nama_kasir]);
    }

    public function getBarang($kodeBarang)
    {
        // Mengambil data Barang berdasarkan Kode Barang
        $barang = BarangModel::where('kode_barang', $kodeBarang)->first();

        return response()->json([
            'id_barang' => $barang->id_barang,
            'kode_barang' => $barang->kode_barang,
            'nama_barang' => $barang->nama_barang,
            'harga' => $barang->harga
        ]);
    }

    public function simpan(Request $request)
    {
        $historyfakturbarangmodel = new HistoryFakturBarangModel;
        $historyfakturbarangmodel->no_faktur = $request->input('no_faktur');
        $historyfakturbarangmodel->kode_kasir = $request->input('kode_kasir');
        $historyfakturbarangmodel->nama_kasir = $request->input('nama_kasir');
        $historyfakturbarangmodel->waktu_input = $request->input('waktu');
        $historyfakturbarangmodel->total = $request->input('total');
        $historyfakturbarangmodel->jumlah_bayar = $request->input('jumlah_bayar');
        $historyfakturbarangmodel->kembali = $request->input('kembali');
        $historyfakturbarangmodel->save();

        $id_faktur = $historyfakturbarangmodel->getKey();

        foreach($request->input('nama_barang') as $key => $value) {
            $historybarang = new HistoryBarangModel;
            $historybarang->id_faktur = $id_faktur;
            $historybarang->id_barang = $request->id_barang[$key];
            $historybarang->qty_barang = $request->qty[$key];
            $historybarang->jumlah_harga_barang = $request->subtotal[$key];
            $historybarang->save();
        }
    }
}
