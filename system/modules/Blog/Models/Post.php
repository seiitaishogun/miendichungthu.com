<?php

namespace Modules\Blog\Models;

use App\Traits\ModelLanguages;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Traits\RecordsActivity;
use Modules\CustomField\Traits\HasCustomFields;
use Modules\User\Models\User;
use Plugins\SEO\Traits\Seoable;
use Plugins\ViewCounter\Traits\ViewCounter;

class Post extends Model
{
    use ModelLanguages, RecordsActivity, Seoable, ViewCounter, HasCustomFields;

    protected $fillable = [
        'featured',
        'published',
        'published_at',
        'thumbnail',
        'main_category',
        'user_id',
        'address',
        'province',
        'district',
        'position'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'published_at'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'published' => 'boolean'
    ];

    protected $with = [
        'fieldDatas'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->position = static::changePosition($model, $model->position);
        });

        static::deleting(function ($model) {
            (new static())->where('position', '>', $model->position)->decrement('position');
        });
    }

    public function getLastPosition()
    {
        return (new static())->max('position');
    }

    public static function changePosition($model, $position)
    {
        if (! $position) {
            return (new static())->getLastPosition() + 1;
        }
        if (static::positionExists($position,$model)) {
            (new static())->where('position', '>=', $position)->increment('position');
        }
        return $position;
    }

    public static function positionExists($position,$model)
    {
        return (new static())->where('id','<>',$model->id)->where('position', $position)->first();
    }

    public function languages()
    {
        return $this->hasMany(PostLanguage::class);
    }

    public function author()
    {
        return $this->belongsTo(\Modules\User\Models\User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'post_category', 'post_id', 'post_category_id');
    }

    public function maincategories()
    {
        return $this->belongsTo(PostCategory::class,'main_category');
    }

    /**
     * @param $value
     * @return string
     */
    public function getNameOnLogsAttribute($value)
    {
        return $this->language('name') ?: 'blog';
    }

    /**
     * @param $value
     * @return string
     */
    public function getUrlOnLogsAttribute($value)
    {
        return admin_route('post.index');
    }

    public function getListCategoriesAttribute($value)
    {
        return $this->categories->map(function($category) {
            return link_to_route('post.category.show', $category->language('name'), $category->language('slug'));
        })->toArray();

    }
}
