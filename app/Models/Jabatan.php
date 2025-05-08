<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'departemen_id',
        'kode',
        'nama',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Aktif' : 'Tidak Aktif';
    }
}
