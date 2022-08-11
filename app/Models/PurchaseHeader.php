<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHeader extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'purchase_headers';
    protected $guarded = [];
    protected $casts = [
        'id' => 'string'
    ];
    protected $keyType = 'string';
    public $incrementing = false;

    public function details(){
        return $this->hasMany(PurchaseDetail::class, 'purchase_id', 'id');
    }
}
