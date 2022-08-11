<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'transaction_details';
    protected $guarded = [];
    protected $casts = [
        'transaction_id' => 'string'
    ];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'transaction_id';

    public function book(){
        return $this->hasOne(Book::class, 'id', 'book_id');
    }
}
