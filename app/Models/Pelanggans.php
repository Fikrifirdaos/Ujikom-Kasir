<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggans extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_customer',
        'no_phone',
        'address'
    ];

    public function penjualan(){

        return $this->hasMany(Penjualans::class);
    }
    

}
