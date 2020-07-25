<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Favorite extends Model
{
    /**
     * Favorable model relation
     *
     * @return void
     */
    public function favorable()
    {
        return $this->morphTo();
    }

    /**
     * User relation
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
