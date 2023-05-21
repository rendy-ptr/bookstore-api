<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'tbl_m_book';
    protected $primaryKey = 'id_tmb';


    protected $fillable = [
        'id_tmw',
        'name_book_tmb',
        'price_book_tmb',
        'picture_book_tmb',
        'stock_tmb',
    ];
}
