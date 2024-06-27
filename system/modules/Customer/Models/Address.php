<?php
namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Cart\Models\DraftOrder;
use Modules\Cart\Models\Order;

class Address extends Model
{

    protected $table = 'customer_addresses';

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'phone',
        'district',
        'province',
        'ward',
        'customer_id',
        'default',
        'hospital',
        'specialists',
        'experience',
        'job',
        'prefix'
    ];

    protected $casts = [
        'default' => 'boolean',
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (! $model->getOriginal('default') && request()->input('default')) {
                if ($default = static::where('default', true)->where('customer_id', $model->customer_id)->first()) {
                    $default->update([
                        'default' => false
                    ]);
                }
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function draftOrders()
    {
        return $this->hasMany(DraftOrder::class, 'customer_address_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }
}
