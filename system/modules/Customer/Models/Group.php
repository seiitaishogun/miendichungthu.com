<?php
namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $table = 'customer_groups';

    protected $fillable = [
        'name',
        'description'
    ];

    public static function boot()
    {
        parent::boot();
        
        static::deleting(function ($model) {
            $customer = Customer::where('customer_group_id', $model)->get();
            $customer->each->update([
                'custom_group_id' => 0
            ]);
        });
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'customer_group_id');
    }
}