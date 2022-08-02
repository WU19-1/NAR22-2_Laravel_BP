<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function book(){
        return $this->hasOne(Book::class, 'id', 'book_id');
    }
}
