<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;
    protected $table = "dokter";
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'id_poli'
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }
    
    public $timestamps = false; // Nonaktifkan timestamp
}
