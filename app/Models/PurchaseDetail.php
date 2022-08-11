<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'purchase_details';
    protected $guarded = [];

    public function book(){
        return $this->hasOne(Book::class, 'id', 'book_id');
    }
}
