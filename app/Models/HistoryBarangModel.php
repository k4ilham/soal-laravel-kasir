<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryBarangModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_history_barang';
    protected $fillable = [
        'id_history_barang',
        'id_faktur',
        'id_barang',
        'qty_barang',
        'jumlah_harga_barang',
    ];
    protected $table = 'history_barang';

     // tambahkan relasi dengan tabel barang
     public function barang()
     {
         return $this->belongsTo(BarangModel::class, 'id_barang');
     }

     // Relasi dengan model HistoryFakturBarangModel
    public function historyFaktur()
    {
        return $this->belongsTo(HistoryFakturBarangModel::class, 'id_history_barang');
    }
}
