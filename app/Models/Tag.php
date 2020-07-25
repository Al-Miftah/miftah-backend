<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    /**
     * Speech relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function speeches()
    {
        return $this->morphedByMany(Speech::class, 'taggable');
    }
}
