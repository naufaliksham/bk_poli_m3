<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $table = "pasien";
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'alamat',
        'no_ktp',
        'no_hp',
        'no_rm',
    ];

    // public static function boot()
    // {
    //     parent::boot();
    
    //     static::creating(function ($pasien) {

    //         // Cek apakah nomor KTP sudah terdaftar
    //         $ktpExists = static::where('no_ktp', $pasien->no_ktp)->exists();
    //         if ($ktpExists) {
    //             return;
    //         }
    //         // Cek apakah nomor rekam medis sudah ada atau belum
    //         if (!$pasien->no_rm) {
    //             $tahunBulan = date('Ym');
                
    //             // Cek apakah sedang ada role admin yang membuat pasien
    //             // dd(\request());
    //             $isPasien = \request()->role == 2; // Sesuaikan dengan logika role admin pada aplikasi Anda
    //             // Jika bukan admin yang membuat, set nomor rekam medis
    //             if ($isPasien) {
    //                 // Cek angka terbesar dari nomor rekam medis
    //                 $latestNumber = static::where('no_rm', 'like', $tahunBulan . '%')
    //                     ->max('no_rm');

    //                 // Jika belum ada nomor rekam medis, set ke 1
    //                 $nomorUrut = $latestNumber ? intval(substr($latestNumber, -3)) + 1 : 1;

    //                 $pasien->no_rm = $tahunBulan . '-' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
    //             }
    //         }
    //     });
    // }
    

    public $timestamps = false; // Nonaktifkan timestamp
}
