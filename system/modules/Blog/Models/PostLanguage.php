<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class PostLanguage extends Model
{
    protected $fillable = [
        'locale',
        'name',
        'slug',
        'description',
        'content',
        'tags',
        'post_id'
    ];

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getLinkAttribute()
    {
        $category = $this->post->categories->first();
        return route('post.show', [
            'category' => $category ? $category->language('slug', $this->locale) : 'category',
            'slug' => $this->getAttribute('slug')
        ]);
    }
}