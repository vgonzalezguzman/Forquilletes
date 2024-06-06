<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'address',
        'owner',
        'uploader',
        'email',
        'phone',
        'website',
        'avatar',
        'lat',
        'lng',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'rId');
    }
    public function plats()
    {
        return $this->hasMany(Plat::class, 'rId');
    }
}
