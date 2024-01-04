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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($pasien) {
            $pasien->no_rm = 'RM' . date('YmdHis');
        });
    }

    public $timestamps = false; // Nonaktifkan timestamp
}
