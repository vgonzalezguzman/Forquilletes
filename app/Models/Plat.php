<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plat extends Model
{
    use HasFactory;

    protected $fillable = [
        'rId',
        'name',
        'price',
        'tId',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'rId');
    }

    public function user()
    {
        return $this->belongsTo(PlatType::class, 'tId');
    }
    public function type()
    {
        return $this->belongsTo(PlatType::class, 'tId');
    }
}
