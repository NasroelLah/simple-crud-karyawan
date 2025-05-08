<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $fillable = [
        'karyawan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_cuti',
        'alasan',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'status' => 'boolean',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Disetujui' : 'Ditolak';
    }
    public function getJenisCutiLabelAttribute()
    {
        return match ($this->jenis_cuti) {
            'cuti_tahunan' => 'Cuti Tahunan',
            'cuti_besar' => 'Cuti Besar',
            'cuti_sakit' => 'Cuti Sakit',
            default => 'Cuti Lainnya',
        };
    }
}
