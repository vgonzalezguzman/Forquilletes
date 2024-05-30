<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rId',
        'uId',
        'title',
        'description',
        'rating',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'rId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uId');
    }
}
