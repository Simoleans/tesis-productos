<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'photo', 'description'];

    //boot created user_id auth
    protected static function boot()
    {
        parent::boot();
        self::creating(function($table){
            $table->user_id = auth()->id();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
