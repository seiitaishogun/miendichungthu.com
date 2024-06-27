<?php

namespace Modules\Page\Models;

use App\Traits\ModelLanguages;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Traits\RecordsActivity;
use Plugins\SEO\Traits\Seoable;
use Plugins\ViewCounter\Traits\ViewCounter;

class Page extends Model
{
    use ModelLanguages, RecordsActivity, Seoable, ViewCounter;

    protected $fillable = [
        'thumbnail',
        'published',
        'published_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'published_at'
    ];

    protected $casts = [
        'published' => 'boolean'
    ];

    public function languages()
    {
        return $this->hasMany(PageLanguage::class);
    }

    /**
     * @param $value
     * @return string
     */
    public function getNameOnLogsAttribute($value)
    {
        return $this->language('name') ?: 'page';
    }

    /**
     * @param $value
     * @return string
     */
    public function getUrlOnLogsAttribute($value)
    {
        return admin_route('page.index');
    }
}
