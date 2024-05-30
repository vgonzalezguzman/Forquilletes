<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantContact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rId',
        'cId',
        'url',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'rId');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'cId');
    }
}
