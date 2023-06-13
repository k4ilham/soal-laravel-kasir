<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'id_barang',
        'nama_barang',
        'kode_barang',
        'harga',
    ];
    protected $table = 'barang';

    // Relasi dengan model HistoryBarangModel
    public function historyBarang()
    {
        return $this->hasMany(HistoryBarangModel::class, 'id_barang');
    }
}
