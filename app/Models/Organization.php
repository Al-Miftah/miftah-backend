<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Organization extends Model
{

    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Filter active organizations
     *
     * @param [type] $query
     * @return void
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }
    /**
     * Who created the organization
     *
     * @return void
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Organization donations
     *@return mixed
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Admins of the organization
     *@return mixed
     */
    public function admins()
    {
        return $this->belongsToMany(User::class, 'organization_admin', 'organization_id', 'user_id')
                ->withTimestamps()
                ->withPivot('membership');
    }
}
