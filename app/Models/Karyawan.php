<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'departemen_id',
        'jabatan_id',
        'nik',
        'nama',
        'email',
        'no_hp',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'jabatan',
        'foto',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function cuti()
    {
        return $this->hasMany(Cuti::class);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Aktif' : 'Tidak Aktif';
    }
}
