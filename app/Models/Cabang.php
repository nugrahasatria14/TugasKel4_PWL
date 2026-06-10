<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabang extends Model
{
    protected $fillable = ['nama', 'kota', 'alamat'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class);
    }

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    public function mutasiStoks(): HasMany
    {
        return $this->hasMany(MutasiStok::class);
    }
}