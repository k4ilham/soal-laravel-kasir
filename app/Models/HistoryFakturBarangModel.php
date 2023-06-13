<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryFakturBarangModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_faktur';
    protected $fillable = [
        'id_faktur',
        'no_faktur',
        'kode_kasir',
        'nama_kasir',
        'waktu_input',
        'total',
        'jumlah_bayar',
        'kembali',
    ];
    protected $table = 'history_faktur_barang';

    // Relasi dengan model HistoryBarangModel
    public function historyBarang()
    {
        return $this->hasMany(HistoryBarangModel::class, 'id_history_barang');
    }

    // Relasi dengan model KasirModel
    public function kasir()
    {
        return $this->belongsTo(KasirModel::class, 'kode_kasir', 'kode_kasir');
    }
}
