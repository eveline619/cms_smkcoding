<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','category_id', 'title', 'slug', 'desc', 'img', 'views', 'status', 'publish_date'];

// relasi ke categories
public function User(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function Category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}
}
