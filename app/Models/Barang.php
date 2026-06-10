<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $fillable = ['kode_barang', 'nama', 'satuan', 'harga'];

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class);
    }

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function mutasiStoks(): HasMany
    {
        return $this->hasMany(MutasiStok::class);
    }
}