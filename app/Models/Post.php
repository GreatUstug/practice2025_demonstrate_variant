<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $fillable = [
        'title',
        'text',
    ];
    
    protected static function booted()
    {
        static::creating(function ($post) {
            $post->user_id = Auth::id();
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory, AsSource, Filterable, Attachable;
}