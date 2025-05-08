<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'karyawan_id',
        'penilai_id',
        'tanggal_penilaian',
        'nilai',
        'komentar',
    ];

    protected $casts = [
        'tanggal_penilaian' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function getNilaiLabelAttribute()
    {
        return match ($this->nilai) {
            1 => 'Sangat Buruk',
            2 => 'Buruk',
            3 => 'Cukup',
            4 => 'Baik',
            5 => 'Sangat Baik',
            default => 'Tidak Diketahui',
        };
    }
}
