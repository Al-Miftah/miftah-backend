<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Donation extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    /**
     * Save amounts to lower denominations
     *
     * @param [type] $value
     * @return void
     */
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value * 100;
    }

    /**
     * Retrive amount in highest denomination
     *
     * @param [type] $value
     * @return float
     */
    public function getAmountAttribute($value)
    {
        return number_format(($value / 100), 2);
    }
    
    /**
     * User who made the donation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function donor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Organization Donation for
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

}
