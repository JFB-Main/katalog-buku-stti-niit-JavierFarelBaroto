<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BukuModel;

//Model used for kategori table in the database

class KategoriModel extends Model
{
    use HasFactory;


    protected $table = 'kategori'; 
    protected $fillable = ['name'];

    public function buku()
    {
        return $this->hasMany(BukuModel::class, 'category_id');
    }

}
