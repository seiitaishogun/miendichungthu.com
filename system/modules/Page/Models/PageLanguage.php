<?php

namespace Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;

class PageLanguage extends Model
{
    protected $fillable = [
        'locale',
        'name',
        'slug',
        'description',
        'content',
        'page_id'
    ];

    public $timestamps = false;

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}