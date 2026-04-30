<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = [
        'title',
        'content',
        'author',
        'slug',
        'cover_media_id'
    ];

    public function coverMedia()
    {
        return $this->belongsTo(Media::class, 'cover_media_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'post_labels', 'post_id', 'label_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories', 'post_id', 'category_id');
    }
}
