<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\KategoriModel;


//Model used for buku table in the database
class BukuModel extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = ['title', 'author', 'description', 'cover', 'category_id'];

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'category_id');
    }

}
