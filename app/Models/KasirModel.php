<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_kasir';
    protected $fillable = [
        'id_kasir',
        'kode_kasir',
        'nama_kasir',
    ];
    protected $table = 'kasir';

    // Relasi dengan model HistoryFakturBarangModel
    public function historyFaktur()
    {
        return $this->hasMany(HistoryFakturBarangModel::class, 'kode_kasir', 'kode_kasir');
    }
}
