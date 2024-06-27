<?php

namespace Modules\Blog\Models;

use App\Traits\ModelLanguages;
use App\Traits\ModelNested;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Traits\RecordsActivity;
use Plugins\SEO\Traits\Seoable;
use Plugins\ViewCounter\Traits\ViewCounter;

/**
 * @property bool published
 * @property integer parent_id
 * @property string thumbnail
 */
class PostCategory extends Model
{
    use ModelNested, ModelLanguages, RecordsActivity, Seoable;

    protected $fillable = [
        'parent_id',
        'published',
        'thumbnail',
        'level',
        'position',
    ];

    protected $casts = [
        'published' => 'boolean'
    ];

    // If you must protect id, please put id to array $protect
    protected static $protects = [];

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
        return $this->hasMany(PostCategoryLanguage::class, 'post_category_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category', 'post_category_id', 'post_id');
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    /**
     * @param $value
     * @return string
     */
    public function getNameOnLogsAttribute($value)
    {
        return $this->language('name') ?: 'category';
    }

    /**
     * @param $value
     * @return string
     */
    public function getUrlOnLogsAttribute($value)
    {
        return admin_route('post.category.index');
    }

    public function getParentForSelection($locale = null, $root = true)
    {
        return $this->getNestedMenusForChoose($locale, $root);
    }

    public function getRootAttribute($value)
    {
        return $this->getRootCategories();
    }

    public function getRootCategories()
    {
        if($this->getAttribute('parent_id') > 0) {
            $parent = (new static)->where('id', $this->getAttribute('parent_id'))->first();
            return $parent ? $parent->getRootCategories() : $this;
        }

        return $this;
    }

    public static function getProtects()
    {
        return static::$protects;
    }
}
