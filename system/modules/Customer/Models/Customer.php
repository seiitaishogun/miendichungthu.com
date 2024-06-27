<?php

namespace Modules\Customer\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Activity\Traits\RecordsActivity;
use Modules\Cart\Models\DraftOrder;
use Modules\Cart\Models\Order;
use Modules\Customer\Notifications\ResetPassword;
use Modules\CustomField\Traits\HasCustomFields;

class Customer extends Authenticatable
{
    use Notifiable, RecordsActivity, HasCustomFields;

    protected static $modelEvents = [
        'created',
        'deleted'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'sex',
        'note',
        'tags',
        'activated',
        'recived_promo_mail',
        'customer_group_id',
        'customer_source_id',
        'affiliate',
        'affiliate_code',
        'user_identifycation',
        'user_confirm',
        'user_verify'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'recustomer_token',
        'token'
    ];

    protected $casts = [
        'tags' => 'array',
        'activated' => 'boolean',
        'recived_promo_mail' => 'boolean',
        'sex' => 'boolean',
        'affiliate' => 'boolean'
    ];

    protected $with = [
        'group',
        'source'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->setAttribute('affiliate_code', strtoupper(uniqid()));
            $model->setAttribute('user_verify', strtoupper(uniqid()));
        });

        static::updating(function ($model) {
            if (!$model->getAttribute('affiliate_code')) {
                $model->setAttribute('affiliate_code', strtoupper(uniqid()));
            }
        });
    }

    /**
     * Setting up data
     *
     * @param
     *            $request
     * @return array
     */
    public function readyProfile($request)
    {
        $data = $request->all();

        // change password
        if (!$data['password']) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $data['activated'] = @$data['activated'] == 1;
        $data['affiliate'] = isset($data['affiliate']);

        if (!isset($data['sex'])) {
            $data['sex'] = false;
        }

        if (!isset($data['recived_promo_mail'])) {
            $data['recived_promo_mail'] = false;
        }

        if (!@$data['note']) {
            $data['note'] = '';
        }

        if (!@$data['tags']) {
            $data['tags'] = '';
        }

        $data['setting'] = '';

        return $data;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'customer_group_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'customer_source_id');
    }

    public function draftOrders()
    {
        return $this->hasMany(DraftOrder::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function affiliateOrders()
    {
        return $this->hasMany(Order::class, 'affiliate_code', 'affiliate_code');
    }

    /**
     * Activity logs
     */
    public function getNameOnLogsAttribute($value)
    {
        return $this->email ?: 'customer';
    }

    public function getUrlOnLogsAttribute($value)
    {
        return route('admin.customer.index');
    }

    public function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function getAffiliateLinkAttribute($value)
    {
        return url('') . '?affiliate=' . $this->getAttribute('affiliate_code');
    }

    public function getVerifyLink()
    {
        return url('') . '?user_verify=' . $this->getAttribute('user_verify');
    }

    public function getAffiliateOrderAttribute($value)
    {
        return $this->getAttribute('affiliateOrders')
            ->where('status', 3)
            ->count();
    }

    public function getAffiliateOrderCostAttribute($value)
    {
        return $this->getAttribute('affiliateOrders')
            ->where('status', 3)
            ->sum('latest_price');
    }

    public function getAffiliateTotalCostAttribute($value)
    {
        $percent = intval(option('affiliate') ?: 0) / 100;
        return $this->getAttribute('affiliate_order_cost') * $percent;
    }

    //affiliate_order_cost

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
